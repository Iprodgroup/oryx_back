@extends('layouts.main')

@section('meta')
    <title>{{ $data['title'] }}</title>
    <meta name="description" content="{{ $data['description'] }}">
@endsection()

@section('content')

    <section id="main" style="padding-top: 170px;">
        <div id="content" class="container">
            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="item-page" itemscope="" itemtype="https://schema.org/Article">
                        <meta itemprop="inLanguage" content="ru-RU">

                        <div itemprop="articleBody">
                            <div class="zapret">

                                <h1 class="title about-title">{{ $data['h1'] }}</h1>
                                <br>
                                <div class="zapbody">{!! $data['text'] !!}</div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
