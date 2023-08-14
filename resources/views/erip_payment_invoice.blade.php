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

					Онлайн оплата через ЕРИП

				</div>

			</div>

		</div>

		<div class="invoice_block">

			<h1>Онлайн оплата через ЕРИП заказа №{{ $order->id }}</h1>

			<div class="invoice_content">

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

				<div class="instruction-wrapper">

					<div class="menager-consult text">
						<p>
							Перед проведением платежа онлайн через ЕРИП, необходимо проконсультироваться с менеджером интернет-магазина по наличию товара!
						</p>
						<p>
							Контакты:
							<a href="tel:7150">7150</a>,
							<a href="tel:+375296867150">+375 29 686 71 50</a>,
							<a href="tel:+375336867150">+375 33 686 71 50</a>,
							<a href="tel:+375256667150">+375 25 666 71 50</a>
						</p>
					</div>

					<div class="code-block">
						<div class="qr-code">
							<img src="{{ asset('img/erip_qr_code.jpg') }}">
						</div>
					</div>
				</div>

@php

	$wsb_seed = time();
	$wsb_storeid = "794912919";
	$wsb_order_num = 'ER-'.$order->id;
	$wsb_test = 1;
	$wsb_currency_id = "BYN";
	$wsb_total = $order->price_total + $order->price_delivery;
	$SecretKey = "hd76DS54234";
	$wsb_signature = sha1($wsb_seed.$wsb_storeid.$wsb_order_num.$wsb_test.$wsb_currency_id.$wsb_total.$SecretKey);

@endphp
				<form method="post" action="https://securesandbox.webpay.by/">
					<input type="hidden" name="*scart">
					<input type="hidden" name="wsb_version" value="2">
					<input type="hidden" name="wsb_tab" value="erip">
					<input type="hidden" name="wsb_language_id" value="russian">
					<input type="hidden" name="wsb_storeid" value="{{ $wsb_storeid }}">
					<input type="hidden" name="wsb_store" value="Интернет-магазин 7150.by">
					<input type="hidden" name="wsb_order_num" value="{{ $wsb_order_num }}">
					<input type="hidden" name="wsb_test" value="{{ $wsb_test }}">
					<input type="hidden" name="wsb_currency_id" value="{{ $wsb_currency_id }}">
					<input type="hidden" name="wsb_seed" value="{{ $wsb_seed }}">
					<input type="hidden" name="wsb_customer_name" value="{{ $order->client_name }}">

					<input type="hidden" name="wsb_return_url" value="http://7150.alfasad.by/erip-payment-success">
					<input type="hidden" name="wsb_cancel_return_url" value="http://7150.alfasad.by/erip-payment-cancel">
					<input type="hidden" name="wsb_notify_url" value="http://7150.alfasad.by/erip-payment-notify">

					<input type="hidden" name="wsb_email" value="{{ $order->email }}">
					<input type="hidden" name="wsb_phone" value="{{ $order->phone }}">

					@foreach($order->items as $item)

						<input type="hidden" name="wsb_invoice_item_name[{{ $loop->index }}]" value="{{ $item->name }}">
						<input type="hidden" name="wsb_invoice_item_quantity[{{ $loop->index }}]" value="{{ $item->count }}">
						<input type="hidden" name="wsb_invoice_item_price[{{ $loop->index }}]" value="{{ $item->price }}">

					@endforeach

					@if(doubleval($order->price_delivery))

						<input type="hidden" name="wsb_shipping_name" value="Стоимость доставки">
						<input type="hidden" name="wsb_shipping_price" value="{{ $order->price_delivery }}">

					@endif

					@if(doubleval($order->price_economy))

						<input type="hidden" name="wsb_discount_name" value="Экономия">
						<input type="hidden" name="wsb_discount_price" value="{{ $order->price_economy }}">

					@endif

					<input type="hidden" name="wsb_total" value="{{ $wsb_total }}">
					<input type="hidden" name="wsb_signature" value="{{ $wsb_signature }}">

					<button type="submit" formtarget="_blank">Оплатить</button>

				</form>






			</div>

		</div>

	</div>
</div>

@endsection
