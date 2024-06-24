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
                    <li class="breadcrumb-item"><a href="/novosti">Полезное</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $new->name }}</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="blog  flex flex-wrap flex-row mb-100px" itemscope="" itemtype="https://schema.org/Blog">

                        <div class="category-desc clearfix">
                            <h1 class="title about-title">{{ $data['h1'] }}</h1>
                            <div class="text pl-15px mb-70px">{!! $data['text'] !!}</div>
                        </div>

                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
