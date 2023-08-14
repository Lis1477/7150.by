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

					Успешная оплата

				</div>

			</div>

		</div>

		<div class="success-block">

			<h1>Онлайн олата заказа №{{ $order_id }}</h1>

			<div class="success-content text">
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
