<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestTelegramBot extends Command
{
    protected $signature = 'telegram:test';
    protected $description = 'Test Telegram bot connection';

    public function handle()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        
        if (!$botToken || !$chatId) {
            $this->error('TELEGRAM_BOT_TOKEN или TELEGRAM_CHAT_ID не настроены в .env файле');
            return 1;
        }
        
        $this->info('Отправка тестового сообщения...');
        
        $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => "🔧 Тестовое сообщение от сервера\n\n📅 Дата: " . date('d.m.Y H:i:s'),
            'parse_mode' => 'Markdown'
        ]);
        
        if ($response->successful()) {
            $this->info('Сообщение успешно отправлено!');
            $this->info('Ответ: ' . $response->body());
            return 0;
        } else {
            $this->error('Ошибка отправки сообщения!');
            $this->error('Ответ: ' . $response->body());
            return 1;
        }
    }
} 