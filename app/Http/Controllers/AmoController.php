<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AmoController extends Controller
{
    /**
     * Отправка данных в Telegram
     * 
     * @param array $data Данные для отправки
     * @return bool Успех отправки
     */
    private function sendToTelegram($data)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');
            
            if (!$botToken || !$chatId) {
                Log::error('Не настроены переменные TELEGRAM_BOT_TOKEN или TELEGRAM_CHAT_ID');
                return false;
            }
            
            // Формируем заголовок сообщения
            $text = "⚡️ Поступил новый заказ\n\n";
            
            // Формируем содержание заказа
            $text .= "📦 Cодержание заказа:\n";
            if (!empty($data['tarif'])) {
                $text .= "{$data['tarif']} - 1 шт.\n\n";
            }
            
            // Данные о доставке
            $text .= "🚚 Данные о доставке:\n\n";
            $text .= "● Способ доставки: Классическая\n";
            
            // Формируем полный адрес
            if (!empty($data['address'])) {
                $fullAddress = "город Санкт-Петербург, ";
                $fullAddress .= "ул. {$data['address']}, ";
                if (!empty($data['house'])) $fullAddress .= "д. {$data['house']}";
                if (!empty($data['entrance'])) $fullAddress .= ", подъезд {$data['entrance']}";
                if (!empty($data['flat'])) $fullAddress .= ", кв. {$data['flat']}";
                if (!empty($data['floor'])) $fullAddress .= ", этаж {$data['floor']}";
            }
            
            if (!empty($data['name'])) $text .= "● ФИО: {$data['name']}\n";
            if (!empty($data['phone'])) $text .= "● Контактный номер: {$data['phone']}\n";
            if (isset($fullAddress)) $text .= "● Адрес доставки: {$fullAddress}\n\n";
            
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
            if (!empty($data['sum'])) {
                if (!empty($data['discount'])) {
                    $text .= "💳 Итого (с учетом скидки {$data['discount']}₽): {$data['sum']}₽";
                } else {
                    $text .= "💳 Итого (с учетом стоимости доставки): {$data['sum']}₽";
                }
            }
            
            // Сначала отправляем фото
            $photoPath = public_path('newOrder.jpg');
            if (file_exists($photoPath)) {
                $photoResponse = Http::attach(
                    'photo', 
                    file_get_contents($photoPath), 
                    'newOrder.jpg'
                )->post("https://api.telegram.org/bot{$botToken}/sendPhoto", [
                    'chat_id' => $chatId,
                    'caption' => $text,
                    'parse_mode' => 'HTML'
                ]);

                if ($photoResponse->successful()) {
                    return true;
                }

                // Если отправка фото не удалась, отправляем хотя бы текст
                Log::error('Ошибка отправки фото в Telegram: ' . $photoResponse->body());
            }

            // Если фото не существует или его отправка не удалась, отправляем только текст
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ]);
            if ($response->successful()) {
                return response()->json(['success' => true]);
            }
            
            Log::error('Ошибка отправки в Telegram: ' . $response->body());
            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            Log::error('Исключение при отправке в Telegram: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Обработка формы обратного звонка
     */
    public function call(Request $request)
    {
        // Логируем входящие данные
        Log::info('Call form data:', $request->all());
        
        // Отправляем в Telegram
        $success = $this->sendToTelegram($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Заявка отправлена' : 'Ошибка отправки'
            ]);
        }
        
        // Для не-AJAX запросов
        if ($success) {
            return redirect()->back()->with('success', 'Ваша заявка успешно отправлена!');
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка при отправке заявки.');
        }
    }
    
    /**
     * Обработка оформления заказа (первая форма)
     */
    public function order2(Request $request)
    {
        // Логируем входящие данные
        Log::info('Order2 form data:', $request->all());
        
        // Отправляем в Telegram
        $success = $this->sendToTelegram($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Заказ оформлен' : 'Ошибка оформления заказа'
            ]);
        }
        
        // Для не-AJAX запросов
        if ($success) {
            return redirect()->back()->with('success', 'Ваш заказ успешно оформлен!');
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка при оформлении заказа.');
        }
    }
    
    /**
     * Обработка оформления заказа (вторая форма)
     */
    public function order3(Request $request)
    {
        // Логируем входящие данные
        Log::info('Order3 form data:', $request->all());
        
        // Отправляем в Telegram
        $success = $this->sendToTelegram($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Заказ оформлен' : 'Ошибка оформления заказа'
            ]);
        }
        
        // Для не-AJAX запросов
        if ($success) {
            return redirect()->back()->with('success', 'Ваш заказ успешно оформлен!');
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка при оформлении заказа.');
        }
    }
    
    /**
     * Проверка промокода
     */
    public function checkPromocode(Request $request)
    {
        // Временная заглушка - возвращаем успешный ответ
        return response()->json([
            'success' => true,
            'message' => 'Промокод успешно применен',
            'original_price' => 1000,
            'discount' => 150,
            'discounted_price' => 850,
            'discount_text' => '15%'
        ]);
    }
    
    /**
     * Обработка формы заказа с детальной страницы
     */
    public function submitOrder(Request $request)
    {
        // Логируем входящие данные
        Log::info('submitOrder form data:', $request->all());
        
        // Получаем данные о заказе из сессии
        $orderData = session('order_data');
        $promocode = session('promocode');
        
        // Объединяем данные формы с данными из сессии
        $data = $request->all();
        $data['form_type'] = 'Заказ с детальной страницы';
        
        if ($orderData) {
            $data['tariff'] = $orderData['tariff_name'] ?? '';
            $data['calories'] = $orderData['calories'] ?? '';
            $data['days'] = $orderData['days'] ?? '';
            $data['price'] = $orderData['price'] ?? '';
        }
        
        if ($promocode) {
            $data['promocode_code'] = $promocode['code'] ?? '';
            $data['discount'] = $promocode['discount'] ?? '';
        }
        
        // Отправляем в Telegram
        $success = $this->sendToTelegram($data);
        
        // Очищаем сессию после успешной отправки
        if ($success) {
            session()->forget(['order_data', 'promocode']);
        }
        
        if ($success) {
            return redirect()->route('order.success');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка оформления заказа'
            ]);
        }
    }
} 