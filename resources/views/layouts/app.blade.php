<!DOCTYPE html>
<html>
<head>

    <x-meta>
        <meta name="description" content="">
        <meta name="og:image" content="{{ asset('/images/site/logo.png') }}">
        <meta name="og:title" content=''>
        <meta name="og:description" content="">
        @yield('meta')
    </x-meta>

    <x-styles>
        @yield('styles')
        <link rel="stylesheet" href="{{ asset('/css/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/style.css?v=1') }}">
        <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    </x-styles>

    @php $metas = \App\Models\MetaTeg::where('status', 'active')->get(); @endphp

    @foreach($metas->where('position', 'head') as $head)
        {!! (request()->path() === $head->slug || $head->all_pages) ? $head->code : '' !!}
    @endforeach

</head>
<body class="lk-page {{request()->path()}}-page">

@foreach($metas->where('position', 'header') as $header)
    {!! (request()->path() === $header->slug || $header->all_pages) ? $header->code : '' !!}
@endforeach

<header>
   <!-- <div class="attention-bar  active ">
        <div class="_container pr">
            <div class="attention-bar__text--out">
                <div class="attention-bar__text fs14">Лимит беспошлинного ввоза товаров 1000€ на одно физ. лицо продлили до 1 апреля 2024 года.</div>
            </div>
        </div>
    </div> -->
    <div class="container">
        <x-header></x-header>
        <x-mainNav></x-mainNav>
    </div>
</header>

<div class="menuclose"></div>


@yield('content')

<x-fixedBox></x-fixedBox>
<a id="button"></a>
<x-footer></x-footer>

<x-scripts> @yield('scripts') </x-scripts>
@yield('script')
</body>
</html>
