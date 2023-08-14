@extends('layouts.base')

@section('content')

<div class="simple-page">
	<div class="container">

		<div class="bread-crumbs-block">

			<a href="/" class="current-category-name">Главная</a>

			<div>
				@include('svg.arrow')
			</div>

			<div class="current-category-name-wrapper">

				<div class="current-category-name no-link">

					Сервисные центры

				</div>

			</div>

		</div>

		<div class="simple-page_block">

			<h1>Сервис</h1>

			<div class="service-page_content">

		        <div class="service-page_description text-block">
		            <p>Мы осуществляем гарантийную поддержку строительной и садовой техники, электроинструмента и бытовых приборов.</p>
		            <p>В течение гарантийного срока владелец имеет право на бесплатный ремонт изделия по неисправностям, являющимися следствием производственных дефектов. Без предъявления гарантийного талона, гарантийный ремонт не производится.</p>
		        </div>

		        <h2>Наши сервисные центры:</h2>

				{!! $page->content !!}

		        <h2>Образцы официальных документов:</h2>

		        <div class="service-page_doc-block">

		            <div class="service-page_link-block">
		                
		                <div class="service-page_link">

		                    <div>Договор публичной оферты</div>

		                    <a href="{{ asset('/files/dogovor-servisnoe-obslujivanie-alefservice.pdf') }}" title="Скачать Договор публичной оферты" target="_blank">
		                        Скачать
		                    </a>

		                </div>

		                <div class="service-page_link">

		                    <div>Квитанция сервисного центра</div>

		                    <a href="{{ asset('/files/kvitancia_alefservis_2021.xlsx') }}" title="Скачать квитанцию сервисного центра" target="_blank">
		                        Скачать
		                    </a>

		                </div>

		                <div class="service-page_link">

		                    <div>Акт возврата бракованного товара</div>

		                    <a href="{{ asset('/files/akt_vozvrata_2021.pdf') }}" title="Скачать акт возврата бракованного товара" target="_blank">
		                        Скачать
		                    </a>
		                </div>

		            </div>
		            
		            <div class="service-page_pic-block">

		                <div class="service-page_pic-view-block">

		                    <div class="service-page_pic-button js-pic-left">
		                        &#8249;
		                    </div>

		                    <div class="service-page_pics">

		                        <a 
		                            href="{{ asset('/img/garantiya_1.jpg') }}"
		                            data-fancybox='images'
		                            data-caption="Гарантийный талон"
		                            alt="Гарантийный талон"
		                            title="Открыть Гарантийный талон на весь экран"
		                            class="service-page_slider-pic active"
		                        >
		                            <img src="{{ asset('/img/garantiya_1.jpg') }}">
		                        </a>

		                        <a 
		                            href="{{ asset('/img/garantiya_2.jpg') }}"
		                            data-fancybox='images'
		                            data-caption="Гарантийный талон"
		                            alt="Гарантийный талон"
		                            title="Открыть Гарантийный талон на весь экран"
		                            class="service-page_slider-pic"
		                        >
		                            <img src="{{ asset('/img/garantiya_2.jpg') }}">
		                        </a>

		                        <a
		                            href="{{ asset('/img/kvitancia_alefservis_2021.jpg') }}"
		                            data-fancybox='images'
		                            data-caption="Квитанция"
		                            alt="Квитанция"
		                            title="Открыть Квитанцию на весь экран"
		                            class="service-page_slider-pic"
		                            >
		                            <img src="{{ asset('/img/kvitancia_alefservis_2021.jpg') }}">
		                        </a>

		                    </div>

		                    <div class="service-page_pic-button js-pic-right">
		                        &#8250;
		                    </div>

		                </div>

		                <div class="service-page_pic-header">
		                    <div class="service-page_pic-header-element active">Официальный гарантийный талон</div>
		                    <div class="service-page_pic-header-element">Официальный гарантийный талон</div>
		                    <div class="service-page_pic-header-element">Квитанция</div>
		                </div>

		            </div>

		        </div>

		        <div class="service-page_guarantee-choices">

		            <p><strong>Гарантийные обязательства могут быть частично или полностью отозваны в следующий случаях:</strong></p>

		            <ul>
		                <li><span>&bull;</span>В гарантийном талоне отсутствуют печать импортера, подпись покупателя.</li>
		                <li><span>&bull;</span>Не совпадают заводские номера в данном талоне и на корпусе изделия (двигателя).</li>
		                <li><span>&bull;</span>Заводской номер на изделии и (или) двигателе уничтожен или не читаем.</li>
		                <li><span>&bull;</span>Установлено, что пользователь (оператор) не выполнял требования по эксплуатации устройства, изложенные в руководстве по эксплуатации на изделие.</li>
		                <li><span>&bull;</span>В результате диагностики обнаружены следы неквалифицированного вмешательства в регулировку устройства, напрямую повлиявшие на его дальнейшую нормальную и безопасную эксплуатацию, например, самостоятельные регулировки карбюратора, приведшие к чрезмерному обогащению или обеднению топливной смеси с последующими непоправимыми повреждениями деталей и узловпоршневой группы, самостоятельные регулировки топливного насоса, форсунки, приведшие к изменению характеристик впрыска топливной смеси в камеру сгорания с последующими проблемами с запуском устройства, самостоятельные регулировки или удаление узлов автоматического отключения устройства в случае перегрузки, перегрева и т.п.</li>
		                <li><span>&bull;</span>В результате диагностики обнаружены изменения в конструкции, несанкционированные заводом-изготовителем, удалены детали и узлы, электронные компоненты, установлены неоригинальные детали и узлы, электронные компоненты.</li>
		                <li><span>&bull;</span>Изделие имеет видимые или установленные диагностикой следы механических повреждений, повреждений вызванных воздействием грызунов и насекомых или следы контакта с огнем, агрессивными средами т.п., загрязнения, непосредственно влияющие на работоспособность изделия.</li>
		                <li><span>&bull;</span>В результате диагностики выявлено, что подключаемые к изделию (электростанции) потребители были неисправны и (или) имели потребляемую мощность более, чем заявленная заводом-изготовителем долговременная выходная мощность, к электростанциям с модулями AVR подключались сварочные аппараты, не имеющие маркировки «для работы с электростанциями».</li>
		                <li><span>&bull;</span>В результате диагностики выявлено, что оператор (пользователь) продолжал работу после того, как сработал механизм автоматического отключения устройства или работа этого механизма была заблокирована оператором (пользователем).</li>
		                <li><span>&bull;</span>Уровень масла в двигателе (картере) находится ниже допустимых норм, воздушный и (или) топливный фильтр чрезмерно загрязнен (т.е. не способен выполнять свои функции) или неправильно установлен.</li>
		                <li><span>&bull;</span>Изделие подключалось в электрическую сеть с нестабильными параметрами, а именно: напряжение не находится в интервале 230±5%, постоянно происходят резкие скачки напряжения в результате параллельного подключения других мощных потребителей.</li>
		                <li><span>&bull;</span>Изделие предоставлено в сервисный центр в разобранном виде или без узлов, отсутствие которых не позволяет выявить действительные причины возникших неисправностей.</li>
		                <li><span>&bull;</span>В результате диагностики выявлено, что изделие, предназначенное для частного использования, эксплуатировалось в целях получения коммерческой выгоды (превышение расчетного ресурса), не проходило своевременного техобслуживания.</li>
		            </ul>

		        </div>






			</div>

		</div>

	</div>
</div>

@endsection

@section('css')
@parent

    <link rel="stylesheet" href="{{ asset('css/services.css') }}">

@endsection

@section('scripts')
@parent

<script type="text/javascript" src="{{ asset('js/service_toggler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/service_pic_slider.js') }}"></script>

@endsection