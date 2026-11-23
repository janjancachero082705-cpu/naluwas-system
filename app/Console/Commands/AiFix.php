<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AiFix extends Command
{
    protected $signature = 'ai:fix';

    protected $description = 'I-paste ang error ug ipa-debug sa AI (OpenRouter)';

    private const MAX_ERROR_CHARS = 8000;
    private const MAX_FILES = 3;
    private const CONTEXT_LINES = 60;

    private array $history = [];

    public function handle(): int
    {
        if (! config('services.openrouter.key')) {
            $this->error('Walay OPENROUTER_API_KEY. Susiha ang .env ug dagana ang php artisan config:clear');
            return self::FAILURE;
        }

        $this->info('I-paste ang error dinhi. Kung human na, pindota ang Enter sa BLANGKO nga linya.');
        $this->newLine();

        $lines = [];
        while (($line = fgets(STDIN)) !== false) {
            $line = rtrim($line, "\r\n");
            if (trim($line) === '' && ! empty($lines)) {
                break;
            }
            if (trim($line) !== '') {
                $lines[] = $line;
            }
        }

        $error = trim(implode("\n", $lines));
        if ($error === '') {
            $this->warn('Walay na-paste nga error.');
            return self::FAILURE;
        }
        $error = substr($error, 0, self::MAX_ERROR_CHARS);

        // Pangitaa ang mga file sa sulod sa error
        $snippets = $this->collectFiles($error);

        $prompt = "Error:\n```\n{$error}\n```\n";
        foreach ($snippets as $s) {
            $prompt .= "\nFile: {$s['path']}" . ($s['line'] ? " (error sa linya {$s['line']})" : '') . "\n```\n{$s['code']}\n```\n";
        }

        $prompt = $this->redact($prompt);

        $system = 'Ikaw usa ka eksperto nga Laravel/PHP developer. Susihon ang error ug code nga gihatag. '
            . 'Ihatag: (1) unsay problema ug ngano, (2) ang gi-ayo nga code (ang bahin ra nga kinahanglan usbon), '
            . '(3) mubo nga rason. Kung kulang ang impormasyon, isulti kung unsa pa nga file o detalye ang kinahanglan. '
            . 'Ayaw pag-imbento ug mga function o package nga wala ra. Tubaga sa Bisaya, apan ibilin sa English ang code ug technical terms.';

        $this->history = [
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $prompt],
        ];

        if ($snippets) {
            $this->line('<fg=gray>Gibasa ang: ' . implode(', ', array_column($snippets, 'path')) . '</>');
        } else {
            $this->line('<fg=gray>Walay file path nga nakit-an sa error, ang error text ra ang ipadala.</>');
        }
        $this->info('Gi-analyze... (palihog paabot)');

        $reply = $this->callAi();
        if ($reply === null) {
            return self::FAILURE;
        }
        $this->printReply($reply);

        // Follow-up nga mga pangutana
        while (true) {
            $next = trim((string) $this->ask('May follow-up? (Enter lang aron mogawas)'));
            if ($next === '') {
                break;
            }
            $this->history[] = ['role' => 'user', 'content' => $this->redact($next)];
            $reply = $this->callAi();
            if ($reply === null) {
                break;
            }
            $this->printReply($reply);
        }

        return self::SUCCESS;
    }

    private function collectFiles(string $error): array
    {
        $pathPattern = '(?:[A-Za-z]:[\\\\\/][^\s:"\'()<>|]+?\.php|(?:app|routes|resources|config|database)[\\\\\/][^\s:"\'()<>|]+?\.php)';
        preg_match_all('/(' . $pathPattern . ')(?::|\s+on\s+line\s+|\()?(\d+)?/i', $error, $m, PREG_SET_ORDER);

        $base = realpath(base_path());
        $seen = [];
        $out = [];

        foreach ($m as $match) {
            $real = realpath($match[1]) ?: realpath(base_path($match[1]));
            if (! $real || ! is_file($real) || ! str_starts_with($real, $base)) {
                continue;
            }

            $relative = ltrim(str_replace('\\', '/', substr($real, strlen($base))), '/');

            // Dili apilon: vendor, storage (compiled), ug sensitive files
            if (str_starts_with($relative, 'vendor/') || str_starts_with($relative, 'storage/')) {
                continue;
            }
            $name = strtolower(basename($real));
            if (str_starts_with($name, '.env') || str_contains($name, 'secret') || str_contains($name, 'credentials')) {
                continue;
            }
            if (isset($seen[$relative])) {
                continue;
            }
            $seen[$relative] = true;

            $line = isset($match[2]) && $match[2] !== '' ? (int) $match[2] : null;
            $out[] = ['path' => $relative, 'line' => $line, 'code' => $this->snippet($real, $line)];

            if (count($out) >= self::MAX_FILES) {
                break;
            }
        }

        return $out;
    }

    private function snippet(string $file, ?int $line): string
    {
        $all = file($file, FILE_IGNORE_NEW_LINES);
        $total = count($all);

        // Gamay ang file o walay linya: ipadala ang tibuok (hangtod sa limit)
        if ($line === null || $total <= self::CONTEXT_LINES * 2) {
            $start = 0;
            $end = min($total, 400);
        } else {
            $start = max(0, $line - self::CONTEXT_LINES - 1);
            $end = min($total, $line + self::CONTEXT_LINES);
        }

        $out = [];
        for ($i = $start; $i < $end; $i++) {
            $out[] = str_pad((string) ($i + 1), 4, ' ', STR_PAD_LEFT) . ' | ' . $all[$i];
        }

        return implode("\n", $out);
    }

    private function redact(string $text): string
    {
        $text = preg_replace('/sk-or-v1-[A-Za-z0-9]+/', '[REDACTED_KEY]', $text);
        $text = preg_replace('/(APP_KEY|DB_PASSWORD|REVERB_APP_SECRET|OPENROUTER_API_KEY)\s*=\s*\S+/', '$1=[REDACTED]', $text);
        $text = preg_replace('/base64:[A-Za-z0-9+\/=]{30,}/', '[REDACTED_APP_KEY]', $text);

        return $text;
    }

    private function callAi(): ?string
    {
        try {
            $response = Http::withToken(config('services.openrouter.key'))
                ->timeout(120)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'messages' => $this->history,
                ]);
        } catch (\Throwable $e) {
            $this->error('Connection error: ' . $e->getMessage());
            return null;
        }

        if ($response->failed()) {
            $this->error('Error (' . $response->status() . '): ' . ($response->json('error.message') ?? 'Unknown error'));
            return null;
        }

        $reply = $response->json('choices.0.message.content') ?? 'Walay sagot.';
        $this->history[] = ['role' => 'assistant', 'content' => $reply];

        return $reply;
    }

    private function printReply(string $reply): void
    {
        $this->newLine();
        $this->line($reply);
        $this->newLine();
    }
}