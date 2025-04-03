$(document).ready(function() {
    // Обработка формы заказа через AJAX
    $('#order').on('submit', function(e) {
        e.preventDefault();
        
        // Показываем прелоадер
        $('.loader_block').fadeIn();
        
        // Отправляем данные формы через AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Скрываем прелоадер
                $('.loader_block').fadeOut();
                
                if (response.success) {
                    // Показываем попап с благодарностью
                    $('#thanks_popup').addClass('active').css('display', 'block');;
                    
                    // Очищаем форму
                    $('#order')[0].reset();
                } else {
                    // Показываем ошибку
                    alert(response.message || 'Произошла ошибка при отправке заказа');
                }
            },
            error: function(xhr) {
                // Скрываем прелоадер
                $('.loader_block').fadeOut();
                
                // Показываем ошибку
                console.error('Ошибка отправки формы:', xhr.responseText);
                alert('Произошла ошибка при отправке заказа. Пожалуйста, попробуйте позже.');
            }
        });
    });
    
    // Обработка формы промокода через AJAX
    $('.promocode').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let promocodeError = $('#promocode_error');
        
        // Показываем прелоадер
        $('.loader_block').fadeIn();
        
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Скрываем прелоадер
                $('.loader_block').fadeOut();
                
                if (response.success) {
                    // Обновляем цену
                    $('.my_order_price .h5').html(`<strike>${response.original_price}₽</strike> ${response.discounted_price}₽`);
                    
                    // Обновляем скрытое поле с промокодом
                    $('input[name="promo"]').val(form.find('input[name="promocode"]').val());
                    
                    // Блокируем форму промокода
                    form.find('input[type="text"]').prop('disabled', true);
                    form.find('input[type="submit"]').prop('disabled', true);
                    
                    // Показываем сообщение об успехе
                    promocodeError.text(response.message).css('color', 'green');
                    
                    // Добавляем информацию о скидке
                    if (!form.find('.discount-info').length) {
                        form.append(`<div class="discount-info" style="color: green; margin-top: 10px;">Скидка: ${response.discount_text}</div>`);
                    }
                } else {
                    // Показываем ошибку
                    promocodeError.text(response.message || 'Промокод не найден').css('color', 'red');
                }
            },
            error: function() {
                // Скрываем прелоадер
                $('.loader_block').fadeOut();
                
                // Показываем ошибку
                promocodeError.text('Ошибка проверки промокода').css('color', 'red');
            }
        });
    });
}); 