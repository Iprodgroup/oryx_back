<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" dir="ltr" data-lt-installed="true" lang="ru-ru">
<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(94520712, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/94520712" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <!-- base href="https://oryx.kz/" -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Доставка товаров именитых брендов с США в Казахстан по низким ценам. Доставка обуви, одежды, электроники с Amazon, Ebay, Nike и других брендов в Казахстан.">
    <meta name="generator" content="Joomla! - Open Source Content Management">
    <title></title>
    <link href="/?format=feed&type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0">
    <link href="/?format=feed&type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="yandex-verification" content="5aa3bda515d0c239">
    <link rel="shortcut icon" href="/images/site/favicon.png" type="image/png">
    <link rel="stylesheet" href=" {{ asset('assets/css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/css/jquery.fancybox.min.css') }} " type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="{{ asset('assets/css/css2.css') }} " rel="stylesheet">

    <link rel="stylesheet" href=" {{ asset('assets/css/animate.css') }} " type="text/css">
    <link rel="stylesheet" href=" {{ asset('assets/css/slick.css') }} " type="text/css">
    <link rel="stylesheet" href=" {{ asset('assets/css/slick-theme.css') }} " type="text/css">


    <link rel="stylesheet" href=" {{ asset('assets/css/profile.css') }} " type="text/css">
    <link rel="stylesheet" href=" {{ asset('assets/css/media.css') }} " type="text/css">

    <script src=" {{ asset('assets/js/jquery.min_002.js') }} " type="text/javascript"></script>


</head>


<body class="lk-page profile-page">

<div class="containe">

    <header class="">
        <div class="container">
            <x-header></x-header>
            <x-mainNav></x-mainNav>
        </div>
    </header>

    <div class="menuclose"></div>
    <div class="container"></div>

    @yield('content')

</div>

<x-footer></x-footer>

<x-scripts></x-scripts>

<x-modal></x-modal>

</body>
</html>
