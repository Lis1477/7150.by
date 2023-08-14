@extends('layouts.base')

@section('content')

<div class="invoice-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					Оплата приложением &laquo;Оплати&raquo;

				</div>

			</div>

		</div>

		<div class="invoice_block">

			<h1>Олата заказа №{{ $order->id }} приложением &laquo;Оплати&raquo;</h1>

			<div class="invoice_content js-invoice_content">

				<div class="items-block-wrapper">

					<div class="items-block">

						<div class="items-header">
							<div class="code">
								Код
							</div>
							<div class="name">
								Наименование
							</div>
							<div class="item-price">
								Цена
							</div>
							<div class="item-count">
								Кол-во
							</div>
							<div class="item-line-price">
								Стоимость
							</div>
						</div>
						
						@foreach($order->items as $item)

							<div class="item-lines">
								<div class="code">
									{{ $item->item_id_1c }}
								</div>
								<div class="name">
									<a href="{{ asset('tovar/'.$item->item_id_1c.'/'.str_slug($item->name, '-')) }}" target="_blank">
										{{ $item->name }}
									</a>
								</div>
								<div class="item-price">
									{{ number_format($item->price, 2, '.', '') }}
								</div>
								<div class="item-count">
									{{ $item->count }}
								</div>
								<div class="item-line-price">
									{{ number_format($item->price * $item->count, 2, '.', '') }}
								</div>
							</div>

						@endforeach

					</div>

					<div class="history-page_total-info-block">

						@if(doubleval($order->price_economy))

							<div class="economy">
								Экономия — {{ number_format($order->price_economy, 2, '.', '') }} руб.
							</div>

						@endif

						<div class="delivery">
							Доставка @if($order->shipping){{ '('.$order->shipping.')' }}@endif
							—
							@if(doubleval($order->price_delivery)){{ number_format($order->price_delivery, 2, '.', '') }}@else{{ '0' }}@endif руб.
						</div>

						<div class="total-price">
							Общая стоимость — {{ number_format($order->price_total + $order->price_delivery, 2, '.', '') }} руб.
						</div>

						@if($order->delivery_type != 'самовывоз')

							<div class="delivery-address">
								@if($order->shipping != 'Европочтой до Пункта Выдачи')

									Адрес доставки — г.{{ $order->city }},
									ул. {{ $order->street }},
									д. {{ $order->house }},
									@if($order->corpus){{ 'кор. '.$order->corpus.',' }}@endif
									@if($order->flat){{ 'кв. '.$order->flat.',' }}@endif
									@if($order->entrance){{ 'под. '.$order->entrance.',' }}@endif
									@if($order->floor){{ 'эт. '.$order->floor.',' }}@endif

								@else

									Пункт выдачи — {{ $order->euro_pv }}.

								@endif

							</div>

						@endif

					</div>
					
				</div>

			</div>

			<div class="instruction-wrapper js-instruction-block">
				
				<div class="info">
					<div class="description">
						<div class="title">
							Как это работает?
						</div>
						<div class="text">

							<p>

								@handheld

									Для оплаты приложением «Оплати» нажмите на кнопку «ОПЛАТИ», или откройте приложение «Оплати» на другом мобильном устройстве и отсканируйте qr-код, кликнув на иконку сканера.

								@elsehandheld

									Для оплаты заказа откройте мобильное приложение «Оплати» и отсканируйте QR-код для оплаты, кликнув на иконку сканера.

								@endhandheld

							</p>

							<p>Затем, будет необходимо подтвердить платеж в приложении.</p>

							<p>Чек об оплате будет сохранен в приложении, увидеть историю платежей можно кликнув по иконке «Выписка».</p>

							<p>Для дополнительной информации можно связаться менеджером интернет-магазина по телефонам  <a href="tel:7150">7150</a> единый для всех мобильных операторов или <a href="tel:+375296867150">+375 29 686 71 50</a>, <a href="tel:+375336867150">+375 33 686 71 50</a>,<a href="tel:+375256667150"> +375 25 666 71 50</a>.</p>

						</div>
					</div>

				</div>

				<div class="code js-code">

					@handheld

						<div class="title">
							Нажмите на кнопку:
						</div>

						<div class="button">
							<a href="https://getapp.o-plati.by/map/?app_link={{ $qr_string }}">
								<img src="{{ asset('img/logo_oplati_white.png') }}">
							</a>
						</div>

						<div class="title">
							или
						</div>

					@endhandheld

					<div class="title">
						Отсканируйте QR-код:
					</div>
					<div class="qr-code-block">
						{!!
							QrCode::encoding('UTF-8')
								->errorCorrection('H')
								->size(250)
								->margin(1)
								->generate($qr_string)
						 !!}
					</div>
					<div
						class="waiting-status js-waiting-status"
						data-qr_id="{{ $qr_id }}"
						data-order_id="{{ $order->id }}"
					>
						Ожидаем подтверждение платежа
					</div>
				</div>

				<div class="update-payment js-update-code">

					<div class="result-status js-oplati-status"></div>

					<div class="update-button">
						<form method="post" action="{{ asset('oplati-payment-page') }}">
							{{ csrf_field() }}
							<input type="hidden" name="order_id" value="{{ $order->id }}">
							<button type="subscribe">Обновить qr-код</button>
						</form>
					</div>

				</div>
			</div>

			<div class="final-block js-final-block">
				<p>Заказ оплачен. Спасибо!</p>
				<p>Ожидайте звонка менеджера для уточнения деталей.</p>

				@auth

					<p class="cabinet-link">
						Детали заказа можно увидеть в
						<a href="{{ asset('cabinet/history') }}">личном кабинете</a>
					</p>

				@endauth

				<p class="return-link">
					<a href="/">Вернуться в магазин</a>
				</p>
			</div>

		</div>

	</div>
</div>

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/oplati.js') }}"></script>

@endsection