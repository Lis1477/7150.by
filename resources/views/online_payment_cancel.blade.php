@extends('layouts.base')

@section('content')

<div class="success-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					Платеж отклонен

				</div>

			</div>

		</div>

		<div class="success-block">

			<h1>Онлайн оплата заказа №{{ $order_id }} отклонена</h1>

			<div class="success-content text">
				<p>Платеж не прошел!</p>

				<p>
					Возможно технические неполадки, пожалуйста, свяжитесь с менеджером магазина по телефонам
					<a href="tel:7150">7150</a>,
					<a href="tel:+375296867150">+375 29 686 71 50</a>,
					<a href="tel:+375336867150">+375 33 686 71 50</a>,
					<a href="tel:+375256667150">+375 25 666 71 50</a>
					или электронной почте
					<a href="mailto:7150@7150.by">7150@7150.by</a>.
				</p>

				<p class="return-link">
					<a href="/">Вернуться в магазин</a>
				</p>
			</div>
		</div>

	</div>
</div>

@endsection
