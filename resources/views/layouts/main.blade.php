<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" dir="ltr" data-lt-installed="true" lang="ru-ru">
<head>
    <!-- base href="https://oryx.kz/" -->
    <meta name="description" content="Доставка товаров именитых брендов с США в Казахстан по низким ценам. Доставка обуви, одежды, электроники с Amazon, Ebay, Nike и других брендов в Казахстан.">
    <title>Быстрая доставка посылок из США в Казахстан</title>
    <link href="/?format=feed&type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0">
    <link href="/?format=feed&type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0">
    <x-meta></x-meta>
    <link rel="shortcut icon" href="/images/site/favicon.png" type="image/png">
    <x-styles> @yield('styles') </x-styles>
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
    <a id="scroll" class="" style="padding: 10px; background-color: #e65a57"><svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z"/></svg></a>
    <x-fixedBox></x-fixedBox>
</div>

<x-footer></x-footer>

<x-scripts> @yield('scripts') </x-scripts>

<x-modal></x-modal>

</body>
</html>
