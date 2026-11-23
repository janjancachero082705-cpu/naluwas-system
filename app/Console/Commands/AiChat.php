<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AiChat extends Command
{
    protected $signature = 'ai:chat {message? : Usa ka pangutana (kung walay butang, mag-chat mode)}';

    protected $description = 'Makig-chat sa AI (OpenRouter) gikan sa terminal';

    private array $history = [];

    public function handle(): int
    {
        if (! config('services.openrouter.key')) {
            $this->error('Walay OPENROUTER_API_KEY. Susiha ang .env ug dagana ang php artisan config:clear');
            return self::FAILURE;
        }

        $this->history = [[
            'role' => 'system',
            'content' => 'Ikaw ang assistant sa Tingalan Naluwas Church. Tubaga ang user sa parehas nga language nga iyang gigamit.',
        ]];

        // Usa ka pangutana ra
        if ($this->argument('message')) {
            $this->line($this->ask_ai($this->argument('message')));
            return self::SUCCESS;
        }

        // Chat mode
        $this->info('AI Chat. I-type ang "exit" aron mogawas.');
        while (true) {
            $input = trim((string) $this->ask('Ikaw'));
            if ($input === '') {
                continue;
            }
            if (in_array(strtolower($input), ['exit', 'quit', 'q'])) {
                $this->info('Bye!');
                break;
            }
            $this->line('<fg=green>AI:</> ' . $this->ask_ai($input));
            $this->newLine();
        }

        return self::SUCCESS;
    }

    private function ask_ai(string $message): string
    {
        $this->history[] = ['role' => 'user', 'content' => $message];

        // Katapusang 20 ka mensahe ra ang ipadala (gawas sa system prompt)
        $messages = array_merge([$this->history[0]], array_slice($this->history, -20));

        try {
            $response = Http::withToken(config('services.openrouter.key'))
                ->timeout(60)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'messages' => $messages,
                ]);
        } catch (\Throwable $e) {
            array_pop($this->history);
            return 'Connection error: ' . $e->getMessage();
        }

        if ($response->failed()) {
            array_pop($this->history);
            return 'Error (' . $response->status() . '): ' . ($response->json('error.message') ?? 'Unknown error');
        }

        $reply = $response->json('choices.0.message.content') ?? 'Walay sagot.';
        $this->history[] = ['role' => 'assistant', 'content' => $reply];

        return $reply;
    }
}