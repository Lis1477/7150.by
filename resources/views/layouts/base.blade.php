<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@php
    if(!isset($title)) {
        $title = "Интернет-магазин 7150.by";
    }
    if(!isset($keywords)) {
        $keywords = "";
    }
    if(!isset($description)) {
        $description = "";
    }
@endphp

    <title>{{ $title }}</title>
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="description" content="{{ $description }}">

    @php($version = date('Ymd'))

    <link rel="stylesheet" href="{{ asset('css/styles.css?v='.$version) }}">
    <link id="js-adaptive" rel="stylesheet" href="{{ asset('css/adaptive.css?v='.$version) }}">

@section('css')
@show

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K4VRQKS');</script>
<!-- End Google Tag Manager -->

</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K4VRQKS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@include('includes.header')

<div class="content-area">
    @yield('content')
</div>

@include('includes.footer')

@mobile

<div class="screen-switch-wrapper">

    <div class="screen-switch-button js-screen-switch"></div>
    
</div>

@endmobile

@include('auth.popups.popup_login')
@include('popups.note')
@include('popups.one_click_order_form')
@include('popups.feedback')
@include('popups.want_cheaper')


<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"> </script>
<script type="text/javascript" src="{{ asset('js/jquery.session.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/screen_switcher.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/menu_mobile.js?v='.$version) }}"></script>
<script type="text/javascript" src="{{ asset('js/category_button_handler.js?v='.$version) }}"></script>
<script type="text/javascript" src="{{ asset('js/number_format.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/in_cart.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/user_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/feedback_popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/captcha_validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/favorite_items.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/one_click_order.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cat_link_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/header_phones.js') }}"></script>
<script>
    console.log('маска для телефона');
    $(document).ready(function() {
        $(".phone-input").mask("+375 (99) 999-99-99");
    });
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(94258112, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/94258112" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script src="//code.jivosite.com/widget/sxVDJrDKpQ" async></script>

@section('scripts')
@show

</body>
</html>