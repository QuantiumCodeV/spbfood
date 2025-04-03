<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    /**
     * Обработка AJAX запроса для добавления товара в корзину
     */
    public function addToOrder(Request $request)
    {
        // Получаем данные о товаре
        $orderData = $request->input('data');
        
        // Логируем полученные данные для отладки
        \Log::info('Данные заказа:', $orderData);
        
        // Сохраняем данные в сессии
        Session::put('order_data', $orderData);
        
        // Возвращаем успешный ответ
        return response()->json(['success' => true]);
    }
    
    /**
     * Отображение страницы заказа
     */
    public function order(Request $request)
    {
        // Получаем данные корзины из сессии
        $orderData = Session::get('order_data');
        
        // Если корзина пуста, используем данные по умолчанию
        if (!$orderData) {
            $orderData = [
                'tariff_name' => 'Похудеть',
                'tariff_name_eng' => 'Slim balance',
                'calories' => '950',
                'days' => '1 день',
                'price' => '1000',
                'img' => '/files/slim_img.png'
            ];
        }
        
        // Логируем данные заказа для отладки
        \Log::info('Данные для страницы заказа:', $orderData);
        
        // Получаем промокод из сессии, если он был применен
        $promocode = Session::get('promocode');
        
        // Расчет итоговой стоимости с учетом промокода
        $totalPrice = $orderData['price'];
        $discountedPrice = $totalPrice;
        
        if ($promocode) {
            if ($promocode['type'] == 'percentage') {
                $discountedPrice = $totalPrice - ($totalPrice * $promocode['value'] / 100);
            } else { // fixed
                $discountedPrice = $totalPrice - $promocode['value'];
                if ($discountedPrice < 0) $discountedPrice = 0;
            }
        }
        
        return view('order', [
            'order_data' => $orderData,
            'promocode' => $promocode,
            'total_price' => $totalPrice,
            'discounted_price' => $discountedPrice
        ]);
    }
    
    /**
     * Проверка промокода через AJAX
     */
    public function checkPromocode(Request $request)
    {
        $code = $request->input('promocode');
        
        // Получаем данные корзины из сессии
        $orderData = Session::get('order_data');
        if (!$orderData) {
            return response()->json([
                'success' => false,
                'message' => 'Корзина пуста'
            ]);
        }
        
        // Проверяем промокод в базе данных
        $promocode = Promocode::where('code', $code)->first();
        
        if (!$promocode) {
            return response()->json([
                'success' => false,
                'message' => 'Промокод не найден'
            ]);
        }
        
        // Проверка активности
        if (!$promocode->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Промокод неактивен'
            ]);
        }
        
        // Проверка даты
        $now = now();
        if ($promocode->valid_from && $promocode->valid_from > $now) {
            return response()->json([
                'success' => false,
                'message' => 'Промокод ещё не действует'
            ]);
        }
        
        if ($promocode->valid_until && $promocode->valid_until < $now) {
            // Деактивируем промокод при истечении срока
            $promocode->is_active = false;
            $promocode->save();
            
            return response()->json([
                'success' => false,
                'message' => 'Срок действия промокода истёк'
            ]);
        }
        
        // Проверка количества использований
        if ($promocode->max_uses && $promocode->used_count >= $promocode->max_uses) {
            // Деактивируем промокод при превышении лимита
            $promocode->is_active = false;
            $promocode->save();
            
            return response()->json([
                'success' => false,
                'message' => 'Лимит использования промокода исчерпан'
            ]);
        }
        
        // Рассчитываем скидку
        $totalPrice = $orderData['price'];
        $discount = 0;
        $discountedPrice = $totalPrice;
        
        // Вычисляем скидку
        if ($promocode->type == 'percentage') {
            $discount = $totalPrice * $promocode->value / 100;
            $discountedPrice = $totalPrice - $discount;
        } else { // fixed
            $discount = $promocode->value;
            $discountedPrice = $totalPrice - $discount;
            if ($discountedPrice < 0) $discountedPrice = 0;
        }
        
        // Сохраняем промокод в сессии
        Session::put('promocode', [
            'id' => $promocode->id,
            'code' => $promocode->code,
            'type' => $promocode->type,
            'value' => $promocode->value,
            'discount' => $discount
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Промокод успешно применен',
            'original_price' => $totalPrice,
            'discount' => $discount,
            'discounted_price' => $discountedPrice,
            'discount_text' => $promocode->type == 'percentage' ? $promocode->value . '%' : $promocode->value . '₽'
        ]);
    }
    
    /**
     * Оформление заказа
     */
    public function submitOrder(Request $request)
    {
        // Валидация данных формы
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'telegram_username' => 'nullable|string|max:255',
            'telegram_user_id' => 'nullable|string|max:255',
            // ... другие поля
        ]);
        
        // Получаем данные корзины и промокода из сессии
        $orderData = Session::get('order_data');
        $promocode = Session::get('promocode');
        
        if (!$orderData) {
            return redirect('/')->with('error', 'Ваша корзина пуста');
        }
        
        try {
            // Создаем новый заказ
            $order = new Order();
            $order->first_name = $validated['first_name'];
            $order->last_name = $validated['last_name'];
            $order->email = $validated['email'];
            $order->phone = $validated['phone'];
            $order->address = $validated['address'];
            $order->telegram_username = $validated['telegram_username'] ?? null;
            $order->telegram_user_id = $validated['telegram_user_id'] ?? null;
            $order->order_details = json_encode($orderData);
            $order->ip = $request->ip();
            
            // Обрабатываем промокод
            if ($promocode && isset($promocode['id'])) {
                $order->promocode_id = $promocode['id'];
                $order->discount = $promocode['discount'];
                
                // Увеличиваем счетчик использований промокода
                $promoModel = Promocode::find($promocode['id']);
                if ($promoModel) {
                    $promoModel->used_count += 1;
                    
                    // Если достигнут лимит, деактивируем
                    if ($promoModel->max_uses && $promoModel->used_count >= $promoModel->max_uses) {
                        $promoModel->is_active = false;
                    }
                    
                    $promoModel->save();
                }
            } else {
                $order->discount = 0;
            }
            
            // Сохраняем итоговую цену
            $totalPrice = floatval($orderData['price']);
            $finalPrice = $promocode ? ($totalPrice - $promocode['discount']) : $totalPrice;
            if ($finalPrice < 0) $finalPrice = 0;
            
            $order->total_price = $totalPrice;
            $order->final_price = $finalPrice;
            $order->save();
            
            // Очищаем корзину и промокод из сессии
            Session::forget(['order_data', 'promocode']);
            
            // Передаем данные в AmoController для отправки в Telegram
            $data = array_merge($validated, [
                'sum' => $finalPrice,
                'tarif' => $orderData['tariff_name'] ?? '',
                'house' => $validated['house'] ?? '',
                'entrance' => $validated['entrance'] ?? '',
                'flat' => $validated['flat'] ?? '',
                'floor' => $validated['floor'] ?? '',
                'comment' => $validated['comment'] ?? '',
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            ]);
            
            if ($promocode) {
                $data['promocode_code'] = $promocode['code'];
                $data['discount'] = $promocode['discount'];
            }
            
            app(\App\Http\Controllers\AmoController::class)->sendToTelegram($data);
            
            // Перенаправляем на страницу успешного оформления заказа
            return redirect()->route('order.success');
            
        } catch (\Exception $e) {
            Log::error('Ошибка при оформлении заказа: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Произошла ошибка при оформлении заказа');
        }
    }
    
    /**
     * Страница успешного оформления заказа
     */
    public function orderSuccess($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('order_success', ['order' => $order]);
    }
} 