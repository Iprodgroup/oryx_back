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
                    <li class="breadcrumb-item active" aria-current="page">Условия сервиса</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="item-page" itemscope="" itemtype="https://schema.org/Article">
                        <meta itemprop="inLanguage" content="ru-RU">


                        <div itemprop="articleBody">
                            <div class="about about1 flex flex-wrap between align-center mb-150px"
                                 style="max-width: 1085px;margin-left: 0;">

                                <div class="about-img about-img_anim">
                                    <div class="list list2"></div>
                                    <img src="/images/site/box3.png" class="box box3" alt="box">
                                    <img src="/images/site/box4.png" class="box box4" alt="box">
                                    <img src="/images/site/aero.png" class="aero" alt="box">
                                </div>

                                <div class="about-item" style="max-width:510px">

                                    <h1 class="title about-title">{{ $data['h1'] }}</h1>
                                    <div class="text about-text">{!! $data['text'] !!}</div>
                                </div>

                            </div>


                            <div class="faq mb-100px">
                                @foreach($questions as  $qusetion)
                                    <div class="faq-item">
                                        <div class="faq-head">
                                            {{ $qusetion->question }}<span></span>
                                        </div>
                                        <div class="faq-content">
                                            {!! $qusetion->response !!}
                                        </div>
                                    </div>
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
