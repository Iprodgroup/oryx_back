@extends('layouts.main')

@section('meta')
    <title>{{ $data['title'] }}</title>
    <meta name="description" content="{{ $data['description'] }}">
@endsection()

@section('content')

    <section id="main" style="padding-top: 170px;">
        <div id="content" class="container">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ПОЛИТИКА</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="item-page" itemscope="" itemtype="https://schema.org/Article">
                        <meta itemprop="inLanguage" content="ru-RU">
                        <div itemprop="articleBody">
                            <div class="confi">
                                <h1 class="title about-title">{{ $data['h1'] }}</h1>
                                <div class="">{!! $data['text'] !!}</div>
                                @foreach($rekvisit as $item)
                                    <p>{{ $item->title }} {{ $item->txt }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
