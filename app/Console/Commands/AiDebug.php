<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AiDebug extends Command
{
    protected $signature = 'ai:debug
        {file : Path sa file nga i-debug (pananglitan app/Http/Controllers/MemberController.php)}
        {--error= : Error message nga imong nakita}
        {--log : Apil ang katapusang bahin sa storage/logs/laravel.log}';

    protected $description = 'Ipa-debug sa AI ang usa ka file (OpenRouter)';

    private const MAX_CHARS = 30000;

    public function handle(): int
    {
        if (! config('services.openrouter.key')) {
            $this->error('Walay OPENROUTER_API_KEY. Susiha ang .env ug dagana ang php artisan config:clear');
            return self::FAILURE;
        }

        $path = $this->argument('file');
        if (! file_exists($path)) {
            $path = base_path($path);
        }
        if (! is_file($path)) {
            $this->error('Wala makita ang file: ' . $this->argument('file'));
            return self::FAILURE;
        }

        // Ayaw ipadala ang sensitive files
        $name = strtolower(basename($path));
        if (str_starts_with($name, '.env') || str_contains($name, 'secret') || str_contains($name, 'credentials')) {
            $this->error('Dili ni ipadala sa AI kay sensitive nga file (naay secrets).');
            return self::FAILURE;
        }

        $code = file_get_contents($path);
        if (strlen($code) > self::MAX_CHARS) {
            $this->warn('Dako ang file, ang unang ' . self::MAX_CHARS . ' ka characters ra ang ipadala.');
            $code = substr($code, 0, self::MAX_CHARS);
        }

        $relative = ltrim(str_replace(base_path(), '', $path), '\\/');
        $prompt = "File: {$relative}\n\n```\n{$code}\n```\n";

        if ($error = $this->option('error')) {
            $prompt .= "\nError nga nakita:\n{$error}\n";
        }

        if ($this->option('log')) {
            $logFile = storage_path('logs/laravel.log');
            if (is_file($logFile)) {
                $lines = array_slice(file($logFile), -40);
                $prompt .= "\nKatapusang bahin sa laravel.log:\n" . implode('', $lines) . "\n";
            } else {
                $this->warn('Walay laravel.log nga nakit-an.');
            }
        }

        // I-hide ang mga secrets kung naa sa prompt
        $prompt = preg_replace('/sk-or-v1-[A-Za-z0-9]+/', '[REDACTED_KEY]', $prompt);
        $prompt = preg_replace('/(APP_KEY|DB_PASSWORD|REVERB_APP_SECRET)\s*=\s*\S+/', '$1=[REDACTED]', $prompt);

        $system = 'Ikaw usa ka eksperto nga Laravel/PHP developer. Susihon ang gihatag nga code ug error. '
            . 'Ihatag: (1) unsay problema ug ngano, (2) ang gi-ayo nga code (ang bahin ra nga kinahanglan usbon), '
            . '(3) mubo nga rason. Kung kulang ang impormasyon, isulti kung unsa pa nga file o detalye ang kinahanglan. '
            . 'Ayaw pag-imbento ug mga function o package nga wala ra. Tubaga sa Bisaya, apan ibilin sa English ang code ug technical terms.';

        $this->info("Gi-analyze ang {$relative} ... (palihog paabot)");

        try {
            $response = Http::withToken(config('services.openrouter.key'))
                ->timeout(120)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
        } catch (\Throwable $e) {
            $this->error('Connection error: ' . $e->getMessage());
            return self::FAILURE;
        }

        if ($response->failed()) {
            $this->error('Error (' . $response->status() . '): ' . ($response->json('error.message') ?? 'Unknown error'));
            return self::FAILURE;
        }

        $this->newLine();
        $this->line($response->json('choices.0.message.content') ?? 'Walay sagot.');
        $this->newLine();

        return self::SUCCESS;
    }
}