<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AiUi extends Command
{
    protected $signature = 'ai:ui
        {file? : View file nga i-enhance (opsyonal, mangutana ra siya kung walay butang)}
        {--prompt= : Unsay gusto nimo usbon (opsyonal, mangutana ra siya kung walay butang)}
        {--replace : Ilisi dayon ang original (naay backup)}';

    protected $description = 'Ipa-enhance sa AI ang UI design sa usa ka view file (OpenRouter)';

    private const MAX_CHARS = 25000;   // limit sa tibuok file
    private const PART_MAX = 18000;    // limit sa usa ka bahin (kung gihiwa)
    private const ALLOWED = ['php', 'html', 'css', 'vue', 'js', 'jsx'];

    public function handle(): int
    {
        if (! config('services.openrouter.key')) {
            $this->error('Walay OPENROUTER_API_KEY. Susiha ang .env ug dagana ang php artisan config:clear');
            return self::FAILURE;
        }

        if ($this->argument('file')) {
            $instruction = $this->option('prompt') ?: $this->askInstruction();
            return $this->process($this->argument('file'), $instruction) ? self::SUCCESS : self::FAILURE;
        }

        $this->info('AI UI Enhancer. Ibilin nga blangko ug i-Enter aron mogawas.');
        $this->newLine();

        while (true) {
            $file = $this->pickFile();
            if ($file === null) {
                $this->info('Bye!');
                break;
            }

            $instruction = $this->askInstruction();
            $this->process($file, $instruction);

            $this->newLine();
            if (! $this->confirm('Mag-enhance pa ka ug lain nga page?', false)) {
                $this->info('Bye!');
                break;
            }
            $this->newLine();
        }

        return self::SUCCESS;
    }

    // ---------- Terminal prompts ----------

    private function askInstruction(): string
    {
        $this->line('<fg=gray>Pananglitan: "limpyo ug minimal, slate nga colors ug blue accent", "mas maayo ang spacing", "mobile-friendly"</>');
        $text = trim((string) $this->ask('Unsay gusto nimo usbon? (Enter lang para sa default nga enhancement)'));

        return $text !== ''
            ? $text
            : 'I-enhance ang UI design: mas modern, limpyo, responsive (mobile-friendly), maayo ang spacing, typography ug colors, ug accessible.';
    }

    private function pickFile(): ?string
    {
        while (true) {
            $term = trim((string) $this->ask('Unsa nga page ang i-enhance? I-type ang PANGALAN ra sa page (pananglitan: members, layout, login)'));

            if ($term === '') {
                return null;
            }

            if (strlen($term) > 60 || substr_count($term, ' ') > 4) {
                $this->warn('Taas kaayo ni. Ang pangutana nga ni para sa pangalan sa page ra (pananglitan: layout). Ang imong instruction i-type sa sunod nga pangutana.');
                continue;
            }

            $direct = realpath($term) ?: realpath(base_path($term));
            if ($direct && is_file($direct)) {
                return $direct;
            }

            $matches = $this->findViews($term);

            if (count($matches) === 0) {
                $this->warn("Walay nakit-an nga view nga naay '{$term}'. Sulayi ang lain nga pangalan.");
                continue;
            }

            if (count($matches) > 15) {
                $this->warn(count($matches) . " ka file ang nakit-an. Dugangi ang imong gi-type aron mag-narrow.");
                continue;
            }

            if (count($matches) === 1) {
                $this->line('Nakit-an: ' . $matches[0]);
                if ($this->confirm('Kini ba?', true)) {
                    return base_path($matches[0]);
                }
                continue;
            }

            $choice = $this->choice('Pili ug file', array_merge($matches, ['(Dili ni, mangita balik)']), 0);
            if ($choice === '(Dili ni, mangita balik)') {
                continue;
            }

            return base_path($choice);
        }
    }

    private function findViews(string $term): array
    {
        $dir = resource_path('views');
        if (! is_dir($dir)) {
            return [];
        }

        $base = realpath(base_path());
        $found = [];

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($it as $file) {
            if (! $file->isFile()) {
                continue;
            }
            if (! in_array(strtolower($file->getExtension()), self::ALLOWED)) {
                continue;
            }
            $relative = ltrim(str_replace('\\', '/', substr($file->getRealPath(), strlen($base))), '/');

            if (str_contains($relative, '.ai.')) {
                continue;
            }
            if (stripos($relative, $term) !== false) {
                $found[] = $relative;
            }
        }

        sort($found);

        return $found;
    }

    // ---------- Main work ----------

    private function process(string $path, string $instruction): bool
    {
        $real = realpath($path) ?: realpath(base_path($path));
        $base = realpath(base_path());

        if (! $real || ! is_file($real) || ! str_starts_with($real, $base)) {
            $this->error('Wala makita ang file sulod sa project: ' . $path);
            return false;
        }

        $name = strtolower(basename($real));
        $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
        $relative = ltrim(str_replace('\\', '/', substr($real, strlen($base))), '/');

        if (str_starts_with($name, '.env') || str_contains($name, 'secret') || str_contains($name, 'credentials')
            || str_starts_with($relative, 'vendor/') || str_starts_with($relative, 'storage/')) {
            $this->error('Dili ni ipadala sa AI (sensitive o dili angay nga file).');
            return false;
        }
        if (! in_array($ext, self::ALLOWED)) {
            $this->error('Dili suportado ang file type. Gamita ang .blade.php, .html, .css, .vue, .js o .jsx.');
            return false;
        }

        $original = file_get_contents($real);

        // ----- Pag-andam sa ipadala -----
        $part = null;
        if (strlen($original) > self::MAX_CHARS) {
            $this->warn('Dako ang file (' . number_format(strlen($original)) . ' ka characters; limit ' . number_format(self::MAX_CHARS) . '), mao nga hiwaon nato.');
            $part = $this->choosePart($original);
            if ($part === null) {
                return false;
            }
            $sendText = $part['text'];
        } else {
            $sendText = $original;
        }

        $guide = 'Design guide: limpyo, minimal ug propesyonal. Usa ra ka accent color ug neutral nga base colors (puti/gray/slate). '
            . 'Consistent ang spacing (8px scale), maayo ang typography ug contrast (accessible), maliit ang border-radius ug shadow. '
            . 'Likayi ang mga gradient, neon, sobra nga animation, ug emoji, aron dili ma-halata nga AI-generated. Responsive (mobile-friendly).';

        if ($part && $part['kind'] === 'css') {
            $system = 'Ikaw usa ka senior nga CSS/UI designer. Ibalik ang gi-enhance nga <style> block. '
                . 'MGA lagda: (1) Ayaw usba ang ngalan sa mga selector (class, id, element) nga gigamit sa HTML, ug ayaw tangtanga ang mga rule. '
                . '(2) Ayaw usba ang ngalan sa CSS variables nga naa na; pwede ka magdugang ug bag-o. Ibutang ang palette sa :root variables. '
                . '(3) Usba ang values: colors, spacing, typography, radius, shadow, transitions, ug pwede magdugang ug responsive @media rules. '
                . '(4) Ayaw pagdugang ug external import/CDN. '
                . '(5) Ibalik ang TIBUOK nga <style>...</style> sa USA ra ka code block, walay gi-skip. Una sa code block, mubo nga lista (3-6 ka punto) sa mga gi-usab, sa Bisaya. '
                . $guide;
            $label = 'CSS';
        } elseif ($part && $part['kind'] === 'markup') {
            $system = 'Ikaw usa ka eksperto nga UI/UX designer ug Laravel Blade developer. I-enhance ang layout sa markup base sa instruction. '
                . 'MGA lagda: (1) Ayaw usba ang logic: ibilin nga eksakto ang tanang Blade directives (@if, @foreach, @csrf, @include, @extends, @yield, @section, @stack, ug uban), '
                . 'variables ({{ }}, {!! !!}), route()/url() calls, form action, method, field names, id, ug JS hooks. '
                . '(2) Naay mga placeholder sama sa {{-- __KEEP_BLOCK_0__ --}}: ibilin ang matag usa NGA EKSAKTO, usa ra ka beses, sa husto nga lugar (<head> o sa katapusan sa body). '
                . '(3) Gamita ang CSS framework nga naa na. Ayaw pagdugang ug bag-ong package o external CDN. '
                . '(4) Ayaw pagtangtang ug content o feature, ug ayaw pag-imbento ug route o variable. '
                . '(5) Ibalik ang TIBUOK markup sa USA ra ka code block, walay "...rest of code". Una sa code block, mubo nga lista (3-6 ka punto) sa mga gi-usab, sa Bisaya. '
                . $guide;
            $label = 'Markup';
        } else {
            $system = 'Ikaw usa ka eksperto nga UI/UX designer ug Laravel Blade developer. I-enhance ang UI sa gihatag nga file base sa instruction. '
                . 'MGA lagda: (1) Ayaw usba ang logic: ibilin nga eksakto ang tanang Blade directives (@if, @foreach, @csrf, @include, @extends, @section, ug uban), '
                . 'variables ({{ }}, {!! !!}), route()/url() calls, form action, method, field names, id, ug JS hooks. '
                . '(2) Gamita ang CSS framework nga naa na sa file. Kung walay framework, plain CSS sa <style>. Ayaw pagdugang ug bag-ong package o external CDN. '
                . '(3) Ayaw pagtangtang ug content o feature, ug ayaw pag-imbento ug route o variable. '
                . '(4) Ibalik ang TIBUOK nga file sa USA ra ka code block, walay gi-skip nga bahin. Una sa code block, mubo nga lista (3-6 ka punto) sa mga gi-usab, sa Bisaya. '
                . $guide;
            $label = 'File';
        }

        $prompt = "File: {$relative} (bahin: {$label})\n\nInstruction: {$instruction}\n\nKaron ang code:\n```\n{$sendText}\n```\n";
        $prompt = $this->redact($prompt);

        $this->info("Gi-enhance ang {$relative} [{$label}] ... (mahimong molungtad ug 1-2 ka minuto)");

        try {
            $response = Http::withToken(config('services.openrouter.key'))
                ->timeout(180)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'max_tokens' => 8000,
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
        } catch (\Throwable $e) {
            $this->error('Connection error: ' . $e->getMessage());
            return false;
        }

        if ($response->failed()) {
            $this->error('Error (' . $response->status() . '): ' . ($response->json('error.message') ?? 'Unknown error'));
            return false;
        }

        $reply = (string) $response->json('choices.0.message.content');
        $finish = $response->json('choices.0.finish_reason');

        $pattern = '/```[a-zA-Z0-9_-]*\R(.*?)```/s';
        preg_match_all($pattern, $reply, $m);
        $aiCode = '';
        foreach ($m[1] ?? [] as $block) {
            if (strlen($block) > strlen($aiCode)) {
                $aiCode = $block;
            }
        }
        $explanation = trim(preg_replace($pattern, '', $reply));

        if ($explanation !== '') {
            $this->newLine();
            $this->line($explanation);
        }

        if (trim($aiCode) === '') {
            $this->newLine();
            $this->warn('Walay code block nga gibalik ang AI, wala nay na-save. Sulayi balik.');
            return false;
        }

        if ($finish === 'length') {
            $this->newLine();
            $this->error('Naputol ang sagot sa AI (dili kompleto), mao nga wala ni i-save. Sulayi ang mas gamay nga bahin.');
            return false;
        }

        $aiCode = rtrim($aiCode) . "\n";

        // ----- Ibalik sa tibuok file -----
        if ($part && $part['kind'] === 'css') {
            if (! preg_match('/^\s*<style\b/i', $aiCode)) {
                preg_match('/^<style\b[^>]*>/i', $part['text'], $open);
                $aiCode = ($open[0] ?? '<style>') . "\n" . trim($aiCode) . "\n</style>\n";
            }
            $newCode = substr_replace($original, rtrim($aiCode), $part['offset'], strlen($part['text']));
        } elseif ($part && $part['kind'] === 'markup') {
            foreach ($part['keep'] as $i => $text) {
                $ph = "{{-- __KEEP_BLOCK_{$i}__ --}}";
                if (substr_count($aiCode, $ph) !== 1) {
                    $this->error("Nawala o nadoble ang placeholder #{$i} sa sagot sa AI, mao nga wala ni i-save (aron dili mabungkag ang imong <style>/<script>). Sulayi balik.");
                    return false;
                }
            }
            $newCode = $aiCode;
            foreach ($part['keep'] as $i => $text) {
                $newCode = str_replace("{{-- __KEEP_BLOCK_{$i}__ --}}", $text, $newCode);
            }
        } else {
            $newCode = $aiCode;
        }
        $newCode = rtrim($newCode) . "\n";

        // ----- Pag-check nga wala nausab ang logic -----
        $this->newLine();
        $warnings = [];
        foreach (['@csrf', '@foreach', '@if', '@include', '@extends', '@section', '@yield', '{{', '{!!', 'route('] as $needle) {
            $a = substr_count($original, $needle);
            $b = substr_count($newCode, $needle);
            if ($a !== $b) {
                $warnings[] = "'{$needle}': original {$a}, bag-o {$b}";
            }
        }
        if ($warnings) {
            $this->warn('Pahimangno, nausab ang pila ka important nga bahin. Susiha pag-ayo:');
            foreach ($warnings as $w) {
                $this->line('  - ' . $w);
            }
        } else {
            $this->info('Check: parehas ang Blade directives ug variables sa original.');
        }

        // ----- I-save sa lahi nga file -----
        if (str_ends_with($name, '.blade.php')) {
            $newPath = substr($real, 0, -strlen('.blade.php')) . '.ai.blade.php';
        } else {
            $newPath = substr($real, 0, -strlen($ext)) . 'ai.' . $ext;
        }
        file_put_contents($newPath, $newCode);
        $newRelative = ltrim(str_replace('\\', '/', substr($newPath, strlen($base))), '/');

        $this->newLine();
        $this->info("Na-save ang bag-ong version: {$newRelative}");
        $this->line("Itandi: code --diff \"{$relative}\" \"{$newRelative}\"");
        $this->newLine();

        $doReplace = $this->option('replace') || $this->confirm('Ilisan ang original ani nga bag-ong version? (naay backup)', false);

        if ($doReplace) {
            $backupDir = storage_path('app/ai-backups');
            if (! is_dir($backupDir)) {
                mkdir($backupDir, 0777, true);
            }
            $backup = $backupDir . DIRECTORY_SEPARATOR . date('Ymd_His') . '_' . basename($real);
            copy($real, $backup);
            file_put_contents($real, $newCode);
            @unlink($newPath);

            $this->info("Gi-ilisan na ang {$relative}.");
            $this->line('Backup: ' . ltrim(str_replace('\\', '/', substr($backup, strlen($base))), '/'));
            $this->line('Dagana ang: php artisan view:clear');
            if ($part) {
                $this->line('Tip: i-run balik ang php artisan ai:ui sa samang file aron i-enhance ang laing bahin (CSS o Markup).');
            }
        } else {
            $this->line('Wala giilisan ang original. I-delete ang .ai file kung dili nimo gusto.');
        }

        return true;
    }

    // ---------- Hiwa-on ang dako nga file ----------

    private function choosePart(string $original): ?array
    {
        preg_match_all('/<(style|script)\b[^>]*>.*?<\/\1>/is', $original, $m, PREG_OFFSET_CAPTURE);

        $blocks = [];
        foreach ($m[0] as $i => $hit) {
            $blocks[] = [
                'tag' => strtolower($m[1][$i][0]),
                'text' => $hit[0],
                'offset' => $hit[1],
            ];
        }

        // Markup: ilisi ang dagko nga style/script ug placeholder
        $keep = [];
        $markup = $original;
        for ($i = count($blocks) - 1; $i >= 0; $i--) {
            if (strlen($blocks[$i]['text']) > 300) {
                $keep[$i] = $blocks[$i]['text'];
                $markup = substr_replace($markup, "{{-- __KEEP_BLOCK_{$i}__ --}}", $blocks[$i]['offset'], strlen($blocks[$i]['text']));
            }
        }

        $options = [];
        $map = [];

        foreach ($blocks as $i => $b) {
            if ($b['tag'] !== 'style' || strlen($b['text']) < 300) {
                continue;
            }
            $size = strlen($b['text']);
            if ($size > self::PART_MAX) {
                $this->line("<fg=gray>Gi-skip ang CSS block #{$i} (" . number_format($size) . " ka characters, dako kaayo).</>");
                continue;
            }
            $label = 'CSS (<style> block #' . $i . ', ' . number_format($size) . ' ka characters): para sa colors ug design';
            $options[] = $label;
            $map[$label] = ['kind' => 'css', 'text' => $b['text'], 'offset' => $b['offset']];
        }

        if (strlen($markup) <= self::PART_MAX) {
            $label = 'Markup (HTML/Blade, ' . number_format(strlen($markup)) . ' ka characters): para sa arrangement ug layout. Ang style/script gitago';
            $options[] = $label;
            $map[$label] = ['kind' => 'markup', 'text' => $markup, 'keep' => $keep];
        } else {
            $this->line('<fg=gray>Ang markup (' . number_format(strlen($markup)) . ' ka characters) dako pa kaayo bisan gitago ang style/script.</>');
        }

        if (empty($options)) {
            $this->error('Dili madaot ang file ngadto sa igo nga gagmay nga bahin. Mas maayo nga bahinon nimo ang layout ngadto sa gagmay nga file gamit ang @include (pananglitan sidebar, header, scripts), ug i-enhance ang matag usa.');
            return null;
        }

        $options[] = '(Kanselahon)';
        $choice = $this->choice('Unsa nga bahin ang i-enhance karon?', $options, 0);

        if ($choice === '(Kanselahon)') {
            return null;
        }

        return $map[$choice];
    }

    private function redact(string $text): string
    {
        $text = preg_replace('/sk-or-v1-[A-Za-z0-9]+/', '[REDACTED_KEY]', $text);
        $text = preg_replace('/(APP_KEY|DB_PASSWORD|REVERB_APP_SECRET|OPENROUTER_API_KEY)\s*=\s*\S+/', '$1=[REDACTED]', $text);
        $text = preg_replace('/base64:[A-Za-z0-9+\/=]{30,}/', '[REDACTED_APP_KEY]', $text);

        return $text;
    }
}