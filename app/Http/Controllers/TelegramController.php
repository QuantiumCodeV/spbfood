<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    protected $telegramBotToken;
    protected $telegramChatId;

    public function __construct()
    {
        $this->telegramBotToken = env('7886179624:AAGav9aHN49IjqTWSywsDPSouDtiuiLEKco');
        $this->telegramChatId = env('7006724996');
    }

    /**
     * Отправка сообщения в Telegram
     *
     * @param  array  $data
     * @return bool
     */
    protected function sendToTelegram($data)
    {
        try {
            // Формируем заголовок сообщения
            $text = "⚡️ Поступил новый заказ\n\n";
            
            // Формируем содержание заказа
            $text .= "📦 Cодержание заказа:\n";
            $text .= "{$data['tarif']} - 1 шт.\n\n";
            
            // Данные о доставке
            $text .= "🚚 Данные о доставке:\n\n";
            $text .= "● Способ доставки: Классическая\n";
            
            // Формируем полный адрес
            $fullAddress = "город Москва, ";
            $fullAddress .= "ул. {$data['address']}, ";
            $fullAddress .= "д. {$data['house']}";
            if (!empty($data['entrance'])) $fullAddress .= ", подъезд {$data['entrance']}";
            if (!empty($data['flat'])) $fullAddress .= ", кв. {$data['flat']}";
            if (!empty($data['floor'])) $fullAddress .= ", этаж {$data['floor']}";
            
            $text .= "● ФИО: {$data['name']}\n";
            $text .= "● Контактный номер: {$data['phone']}\n";
            $text .= "● Адрес доставки: {$fullAddress}\n\n";
            
            // Данные клиента
            $text .= "👤 Данные клиента:\n\n";
            if (!empty($data['telegram_username'])) {
                $text .= "● ID [Telegram]: @{$data['telegram_username']}\n";
            }
            if (!empty($data['telegram_user_id'])) {
                $text .= "● ID [Цифровой]: {$data['telegram_user_id']}\n";
            }
            $text .= "● Завершенных заказов: 0\n";
            $text .= "● Скидка за оставленный отзыв: Отсутствует\n";
            $text .= "● Средний чек: 0\n";
            $text .= "● Список последних заказов: Заказов не найдено\n\n";
            
            // Комментарий к заказу
            if (!empty($data['comment'])) {
                $text .= "📝 Пожелания по доставке: {$data['comment']}\n\n";
            }
            
            // Итоговая стоимость
            $text .= "💳 Итого (с учетом стоимости доставки): {$data['sum']}₽";
            
            $response = Http::post("https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage", [
                'chat_id' => $this->telegramChatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ]);
            
            if ($response->successful()) {
                return true;
            }
            
            Log::error('Ошибка отправки в Telegram: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Исключение при отправке в Telegram: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обработка запроса на обратный звонок
     */
    public function callbackRequest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'form_name' => 'nullable|string',
        ]);
        
        // Добавляем тип формы
        $data = $request->all();
        $data['form_type'] = $data['form_name'] ?? 'Заявка на обратный звонок';
        
        // Отправляем данные в Telegram
        $this->sendToTelegram($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Заявка успешно отправлена!'
        ]);
    }

    /**
     * Обработка оформления заказа
     */
    public function submitOrder(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            // другие поля
        ]);
        
        // Получаем данные корзины из сессии
        $orderData = session('order_data');
        $promocode = session('promocode');
        
        // Формируем данные для отправки в Telegram
        $data = $request->all();
        $data['form_type'] = 'Новый заказ';
        
        if ($orderData) {
            $data['tariff_name'] = $orderData['tariff_name'] ?? '';
            $data['calories'] = $orderData['calories'] ?? '';
            $data['days'] = $orderData['days'] ?? '';
            $data['price'] = $orderData['price'] ?? '';
        }
        
        if ($promocode) {
            $data['promocode'] = $promocode['code'];
            $data['discount'] = $promocode['discount'];
            $data['final_price'] = ($orderData['price'] ?? 0) - $promocode['discount'];
        }
        
        // Отправляем данные в Telegram
        $this->sendToTelegram($data);
        
        // Очищаем данные корзины и промокода
        session()->forget(['order_data', 'promocode']);
        
        return response()->json([
            'success' => true,
            'message' => 'Заказ успешно оформлен!'
        ]);
    }
    
    /**
     * Проверка промокода
     */
    public function checkPromocode(Request $request)
    {
        // Делегируем обработку в SiteController
        return app(SiteController::class)->checkPromocode($request);
    }

} 