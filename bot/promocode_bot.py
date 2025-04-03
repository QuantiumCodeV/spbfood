import os
import logging
import asyncio
import requests
from aiogram import Bot, Dispatcher, Router, types
from aiogram.filters import Command, CommandStart
from aiogram.types import Message, InlineKeyboardMarkup, InlineKeyboardButton
from aiogram.fsm.context import FSMContext
from aiogram.fsm.state import State, StatesGroup
from aiogram.fsm.storage.memory import MemoryStorage
from dotenv import load_dotenv

# Загрузка переменных окружения
load_dotenv()

# Настройка логирования
logging.basicConfig(level=logging.INFO)

# API URL
API_URL = os.getenv("API_URL", "http://localhost:8000/api")
API_TOKEN = os.getenv("API_TOKEN")
BOT_TOKEN = os.getenv("TELEGRAM_BOT_TOKEN")

# Конфигурация бота
bot = Bot(token=BOT_TOKEN)
storage = MemoryStorage()
dp = Dispatcher(storage=storage)
router = Router()
dp.include_router(router)

# Классы состояний для FSM
class PromocodeStates(StatesGroup):
    waiting_for_action = State()
    waiting_for_code = State()
    waiting_for_type = State()
    waiting_for_value = State()
    waiting_for_valid_from = State()
    waiting_for_valid_until = State()
    waiting_for_max_uses = State()
    waiting_for_description = State()
    waiting_for_confirmation = State()
    waiting_for_delete_confirmation = State()
    
# Функции для работы с API
async def get_all_promocodes():
    headers = {
        'Authorization': f'Bearer {API_TOKEN}',
        'Accept': 'application/json'
    }
    response = requests.get(f"{API_URL}/promocodes", headers=headers)
    if response.status_code == 200:
        return response.json()
    return []

async def get_promocode(promocode_id):
    headers = {
        'Authorization': f'Bearer {API_TOKEN}',
        'Accept': 'application/json'
    }
    response = requests.get(f"{API_URL}/promocodes/{promocode_id}", headers=headers)
    if response.status_code == 200:
        return response.json()
    return None

async def create_promocode(data):
    headers = {
        'Authorization': f'Bearer {API_TOKEN}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
    try:
        # Добавляем логирование запроса
        logging.info(f"Отправка запроса на создание промокода: {data}")
        response = requests.post(f"{API_URL}/promocodes", json=data, headers=headers)
        
        # Логируем ответ
        logging.info(f"Статус ответа: {response.status_code}")
        logging.info(f"Текст ответа: {response.text}")
        
        if response.status_code == 201:
            return response.json()
        else:
            # Более подробная обработка ошибок
            logging.error(f"Ошибка API: {response.status_code} - {response.text}")
            return None
    except Exception as e:
        # Обработка исключений
        logging.error(f"Исключение при вызове API: {str(e)}")
        return None

async def update_promocode(promocode_id, data):
    headers = {
        'Authorization': f'Bearer {API_TOKEN}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
    response = requests.put(f"{API_URL}/promocodes/{promocode_id}", json=data, headers=headers)
    if response.status_code == 200:
        return response.json()
    return None

async def delete_promocode(promocode_id):
    headers = {
        'Authorization': f'Bearer {API_TOKEN}',
        'Accept': 'application/json'
    }
    response = requests.delete(f"{API_URL}/promocodes/{promocode_id}", headers=headers)
    return response.status_code == 204

# Команды бота
@router.message(CommandStart())
async def cmd_start(message: Message):
    await message.answer(
        "Добро пожаловать в бот управления промокодами! "
        "Используйте /help для получения списка команд."
    )

@router.message(Command("help"))
async def cmd_help(message: Message):
    help_text = (
        "Доступные команды:\n"
        "/list - Показать все промокоды\n"
        "/add - Добавить новый промокод\n"
        "/edit <id> - Редактировать промокод\n"
        "/delete <id> - Удалить промокод\n"
        "/help - Показать это сообщение"
    )
    await message.answer(help_text)

@router.message(Command("list"))
async def cmd_list(message: Message):
    promocodes = await get_all_promocodes()
    if not promocodes:
        await message.answer("Промокоды не найдены.")
        return
    
    result = "Список промокодов:\n\n"
    for promo in promocodes:
        result += f"ID: {promo['id']}\n"
        result += f"Код: {promo['code']}\n"
        result += f"Тип: {promo['type']}\n"
        result += f"Значение: {promo['value']}\n"
        result += f"Активен: {'Да' if promo['is_active'] else 'Нет'}\n"
        result += f"Использовано: {promo['used_count']}\n"
        result += f"Макс. использований: {promo['max_uses'] or 'Не ограничено'}\n"
        result += f"Действует с: {promo['valid_from'] or 'Не указано'}\n"
        result += f"Действует до: {promo['valid_until'] or 'Не указано'}\n"
        result += f"Описание: {promo['description'] or 'Не указано'}\n\n"
    
    await message.answer(result)

@router.message(Command("add"))
async def cmd_add(message: Message, state: FSMContext):
    await state.set_state(PromocodeStates.waiting_for_code)
    await state.update_data(action="add")
    await message.answer("Введите код промокода:")

@router.message(Command("edit"))
async def cmd_edit(message: Message, state: FSMContext):
    command_parts = message.text.split(maxsplit=1)
    if len(command_parts) != 2:
        await message.answer("Пожалуйста, укажите ID промокода для редактирования. Пример: /edit 1")
        return
    
    promocode_id = command_parts[1].strip()
    promocode = await get_promocode(promocode_id)
    if not promocode:
        await message.answer(f"Промокод с ID {promocode_id} не найден.")
        return
    
    await state.set_state(PromocodeStates.waiting_for_code)
    await state.update_data(action="edit", promocode_id=promocode_id, promocode=promocode)
    await message.answer(
        f"Редактирование промокода #{promocode_id}\n"
        f"Текущий код: {promocode['code']}\n\n"
        "Введите новый код промокода или отправьте '-' чтобы оставить текущее значение:"
    )

@router.message(Command("delete"))
async def cmd_delete(message: Message, state: FSMContext):
    command_parts = message.text.split(maxsplit=1)
    if len(command_parts) != 2:
        await message.answer("Пожалуйста, укажите ID промокода для удаления. Пример: /delete 1")
        return
    
    promocode_id = command_parts[1].strip()
    promocode = await get_promocode(promocode_id)
    if not promocode:
        await message.answer(f"Промокод с ID {promocode_id} не найден.")
        return
    
    await state.set_state(PromocodeStates.waiting_for_delete_confirmation)
    await state.update_data(promocode_id=promocode_id)
    
    keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [
            InlineKeyboardButton(text="Да, удалить", callback_data=f"delete_confirm_{promocode_id}"),
            InlineKeyboardButton(text="Отмена", callback_data="delete_cancel")
        ]
    ])
    
    await message.answer(
        f"Вы уверены, что хотите удалить промокод #{promocode_id} ({promocode['code']})?",
        reply_markup=keyboard
    )

# Обработка состояний FSM для добавления/редактирования промокода
@router.message(PromocodeStates.waiting_for_code)
async def process_code(message: Message, state: FSMContext):
    user_data = await state.get_data()
    code = message.text.strip()
    
    if user_data.get('action') == 'edit' and code == '-':
        code = user_data['promocode']['code']
    
    await state.update_data(code=code)
    await state.set_state(PromocodeStates.waiting_for_type)
    
    keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [
            InlineKeyboardButton(text="Процентный", callback_data="type_percentage"),
            InlineKeyboardButton(text="Фиксированный", callback_data="type_fixed")
        ]
    ])
    
    await message.answer("Выберите тип промокода:", reply_markup=keyboard)

@router.callback_query(lambda c: c.data.startswith('type_'))
async def process_type_callback(callback_query: types.CallbackQuery, state: FSMContext):
    await callback_query.answer()
    
    type_value = callback_query.data.split('_')[1]
    await state.update_data(type=type_value)
    
    user_data = await state.get_data()
    action_text = "Введите" 
    if user_data.get('action') == 'edit' and user_data.get('promocode'):
        action_text = f"Текущее значение: {user_data['promocode']['value']}\n\nВведите новое"
    
    await state.set_state(PromocodeStates.waiting_for_value)
    await callback_query.message.answer(f"{action_text} значение промокода:")

@router.message(PromocodeStates.waiting_for_value)
async def process_value(message: Message, state: FSMContext):
    try:
        value = float(message.text.strip())
        await state.update_data(value=value)
        
        # Переходим к следующему шагу - дата начала действия
        await state.set_state(PromocodeStates.waiting_for_valid_from)
        await message.answer("Введите дату начала действия промокода (формат ГГГГ-ММ-ДД) или '-' чтобы оставить пустым:")
    except ValueError:
        await message.answer("Пожалуйста, введите числовое значение для промокода.")

@router.message(PromocodeStates.waiting_for_valid_from)
async def process_valid_from(message: Message, state: FSMContext):
    date_text = message.text.strip()
    
    if date_text == '-':
        await state.update_data(valid_from=None)
    else:
        try:
            # Простая проверка формата даты
            import datetime
            datetime.datetime.strptime(date_text, '%Y-%m-%d')
            await state.update_data(valid_from=date_text)
        except ValueError:
            await message.answer("Неверный формат даты. Пожалуйста, используйте формат ГГГГ-ММ-ДД.")
            return
    
    await state.set_state(PromocodeStates.waiting_for_valid_until)
    await message.answer("Введите дату окончания действия промокода (формат ГГГГ-ММ-ДД) или '-' чтобы оставить пустым:")

@router.message(PromocodeStates.waiting_for_valid_until)
async def process_valid_until(message: Message, state: FSMContext):
    date_text = message.text.strip()
    
    if date_text == '-':
        await state.update_data(valid_until=None)
    else:
        try:
            # Простая проверка формата даты
            import datetime
            datetime.datetime.strptime(date_text, '%Y-%m-%d')
            await state.update_data(valid_until=date_text)
        except ValueError:
            await message.answer("Неверный формат даты. Пожалуйста, используйте формат ГГГГ-ММ-ДД.")
            return
    
    await state.set_state(PromocodeStates.waiting_for_max_uses)
    await message.answer("Введите максимальное количество использований промокода или '-' чтобы оставить пустым:")

@router.message(PromocodeStates.waiting_for_max_uses)
async def process_max_uses(message: Message, state: FSMContext):
    max_uses_text = message.text.strip()
    
    if max_uses_text == '-':
        await state.update_data(max_uses=None)
    else:
        try:
            max_uses = int(max_uses_text)
            await state.update_data(max_uses=max_uses)
        except ValueError:
            await message.answer("Пожалуйста, введите числовое значение для максимального количества использований.")
            return
    
    await state.set_state(PromocodeStates.waiting_for_description)
    await message.answer("Введите описание промокода или '-' чтобы оставить пустым:")

@router.message(PromocodeStates.waiting_for_description)
async def process_description(message: Message, state: FSMContext):
    description = message.text.strip()
    
    if description == '-':
        await state.update_data(description=None)
    else:
        await state.update_data(description=description)
    
    # Получаем все данные и отображаем для подтверждения
    user_data = await state.get_data()
    action = user_data.get('action', 'add')
    
    promocode_data = {
        'code': user_data.get('code'),
        'type': user_data.get('type'),
        'value': user_data.get('value'),
        'valid_from': user_data.get('valid_from'),
        'valid_until': user_data.get('valid_until'),
        'max_uses': user_data.get('max_uses'),
        'description': user_data.get('description'),
        'is_active': True  # По умолчанию активный
    }
    
    confirmation_text = "Пожалуйста, подтвердите создание промокода:\n\n"
    if action == 'edit':
        confirmation_text = f"Пожалуйста, подтвердите редактирование промокода #{user_data.get('promocode_id')}:\n\n"
    
    confirmation_text += f"Код: {promocode_data['code']}\n"
    confirmation_text += f"Тип: {promocode_data['type']}\n"
    confirmation_text += f"Значение: {promocode_data['value']}\n"
    confirmation_text += f"Активен: Да\n"
    confirmation_text += f"Дата начала: {promocode_data['valid_from'] or 'Не указано'}\n"
    confirmation_text += f"Дата окончания: {promocode_data['valid_until'] or 'Не указано'}\n"
    confirmation_text += f"Макс. использований: {promocode_data['max_uses'] or 'Не ограничено'}\n"
    confirmation_text += f"Описание: {promocode_data['description'] or 'Не указано'}\n"
    
    keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [
            InlineKeyboardButton(text="Подтвердить", callback_data="confirm_save"),
            InlineKeyboardButton(text="Отмена", callback_data="cancel_save")
        ]
    ])
    
    await state.set_state(PromocodeStates.waiting_for_confirmation)
    await message.answer(confirmation_text, reply_markup=keyboard)

@router.callback_query(lambda c: c.data == "confirm_save")
async def confirm_save(callback_query: types.CallbackQuery, state: FSMContext):
    await callback_query.answer()
    
    user_data = await state.get_data()
    action = user_data.get('action', 'add')
    
    promocode_data = {
        'code': user_data.get('code'),
        'type': user_data.get('type'),
        'value': user_data.get('value'),
        'valid_from': user_data.get('valid_from'),
        'valid_until': user_data.get('valid_until'),
        'max_uses': user_data.get('max_uses'),
        'description': user_data.get('description'),
        'is_active': True
    }
    
    # Преобразуем значения в правильные типы данных перед отправкой на API
    if promocode_data['value']:
        promocode_data['value'] = float(promocode_data['value'])
    
    if promocode_data['max_uses']:
        promocode_data['max_uses'] = int(promocode_data['max_uses'])
    
    if action == 'add':
        result = await create_promocode(promocode_data)
        logging.info(f"Результат создания промокода: {result}")
        if result:
            await callback_query.message.edit_text(f"Промокод '{promocode_data['code']}' успешно создан!")
        else:
            await callback_query.message.edit_text("Произошла ошибка при создании промокода. Проверьте логи сервера.")
    else:
        promocode_id = user_data.get('promocode_id')
        result = await update_promocode(promocode_id, promocode_data)
        if result:
            await callback_query.message.edit_text(f"Промокод #{promocode_id} успешно обновлен!")
        else:
            await callback_query.message.edit_text(f"Произошла ошибка при обновлении промокода #{promocode_id}.")
    
    await state.clear()

@router.callback_query(lambda c: c.data == "cancel_save")
async def cancel_save(callback_query: types.CallbackQuery, state: FSMContext):
    await callback_query.answer()
    await callback_query.message.edit_text("Операция отменена.")
    await state.clear()

# Колбэки для подтверждения удаления
@router.callback_query(lambda c: c.data.startswith('delete_confirm_'))
async def process_delete_confirm(callback_query: types.CallbackQuery, state: FSMContext):
    await callback_query.answer()
    
    promocode_id = callback_query.data.split('_')[-1]
    success = await delete_promocode(promocode_id)
    
    if success:
        await callback_query.message.edit_text(f"Промокод #{promocode_id} успешно удален.")
    else:
        await callback_query.message.edit_text(f"Ошибка при удалении промокода #{promocode_id}.")
    
    await state.clear()

@router.callback_query(lambda c: c.data == 'delete_cancel')
async def process_delete_cancel(callback_query: types.CallbackQuery, state: FSMContext):
    await callback_query.answer()
    await callback_query.message.edit_text("Удаление отменено.")
    await state.clear()

# Запуск бота
async def main():
    await dp.start_polling(bot)

if __name__ == "__main__":
    asyncio.run(main()) 