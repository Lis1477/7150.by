$(document).ready(function(){

	console.log('статус оплати');

	// устанавливаем интервал для пинга
	var ping_status = setInterval(get_status, 10000);

	// запрос статуса
	function get_status() {

		// берем токен
		var token = $('meta[name=csrf-token]').attr('content');
		var payment_id = $('.js-waiting-status').data('qr_id');
		var order_id = $('.js-waiting-status').data('order_id');

        $.ajax({
            type: 'post',
            url: "/oplati/status",
            data: {
                '_token': token,
                'payment_id' : payment_id,
                'order_id' : order_id,
            },
            success: function(data) {

            	var status_str;

		        if (data == 1) {

		            // скрываем блок с qr-кодом и товарами
		            $('.js-instruction-block, .js-invoice_content').hide();

		            // отображаем блок с финальной информацией
		            $('.js-final-block').show();

            		// отменяем интервал
            		clearInterval(ping_status);

		        } else if (data == 3) {
		            status_str = "Вы отказались от платежа.";
		        } else if (data == 4) {
		            status_str = "У Вас недостаточно средств в кошельке.";
		        } else if (data == 5) {
		            status_str = "Операция отменена.";
		        }

		        if (data == 3 || data == 4 || data == 5) {

	            	// вписываем статус
	            	$('.js-oplati-status').text(status_str);

		            // скрываем блок с qr-кодом
		            $('.js-code').hide();

		            // отображаем блок с кнопкой обновления кода
		            $('.js-update-code').show();

	        		// отменяем интервал
	        		clearInterval(ping_status);

		        }

            },
        });
	}

});
