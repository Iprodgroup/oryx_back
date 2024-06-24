<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" dir="ltr" data-lt-installed="true" lang="ru-ru">
<head>

    <x-meta>@yield('meta')</x-meta>

    <x-styles>@yield('styles')</x-styles>

    @php $metas = \App\Models\MetaTeg::where('status', 'active')->get(); @endphp

    @foreach($metas->where('position', 'head') as $head)
        {!! (request()->path() === $head->slug || $head->all_pages) ? $head->code : '' !!}
    @endforeach

</head>

<body class="lk-page profile-page">

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

@yield('content')

<x-fixedBox></x-fixedBox>

<x-footer></x-footer>

<x-scripts> @yield('scripts') </x-scripts>

<x-modal></x-modal>

@foreach($metas->where('position', 'footer') as $footer)
    {!! (request()->path() === $footer->slug || $footer->all_pages) ? $footer->code : '' !!}
@endforeach

</body>
</html>
