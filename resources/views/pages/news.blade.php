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
                    <li class="breadcrumb-item active" aria-current="page">Полезное</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="blog  flex flex-wrap flex-row mb-100px" itemscope="" itemtype="https://schema.org/Blog">

                        <div class="category-desc clearfix">

                            <h1 class="title about-title">{{ $data['h1'] }}</h1>

                            <div class="text pl-15px mb-70px">{{ $data['text'] }}</div>
                        </div>

                        @foreach($news as $new)
                            <div class="items-row cols-1 row-0 row-fluid clearfix">
                                <div class="span12">
                                    <div class="item column-1" itemprop="blogPost" itemscope="" itemtype="https://schema.org/BlogPosting">

                                        <dl class="article-info muted">

                                            <dt class="article-info-term">
                                            </dt>

                                            <dd class="published">
                                                <span class="icon-calendar" aria-hidden="true"></span>
                                                <time datetime="2021-10-21T09:08:16+00:00" itemprop="datePublished">
                                                    <span class="date-day">{{ $new->day }}</span><span class="datefull">{{ $new->date }}</span>
                                                </time>
                                            </dd>
                                        </dl>


                                        <div class="page-header">
                                            <div class="blog-title">
                                                <a href="/novosti/{{ $new->slug }}" itemprop="url">{{ $new->short_desk }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
