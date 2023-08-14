$(document).ready(function(){
	// на мобилах - переключатель на полную версию сайта

	// проверяем наличие сессии
	var sess = $.session.get('screen_full');
	if (sess) {
		$('#js-adaptive').remove();
		// $('body').css('margin', '10px');
		$('.js-screen-switch').text('Открыть мобильную версию сайта');
	} else {
		$('.js-screen-switch').text('Открыть полную версию сайта');
	}

	$('.js-screen-switch').click(function(){

		if (sess) {
			$.session.remove('screen_full');
			location.reload(true);
		} else {
			$.session.set('screen_full', 'yes');
			location.reload(true);
		}

	});
});
