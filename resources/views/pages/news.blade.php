@extends('layouts.main')

@section('content')

    <section id="main" style="padding-top: 170px;">
        <div id="content" class="container">
            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="blog  flex flex-wrap flex-row mb-100px" itemscope="" itemtype="https://schema.org/Blog">

                        <div class="category-desc clearfix">
                            <div class="title news-title">
                                Новости / Акции
                            </div>

                            <div class="text pl-15px mb-70px">
                                Полезные статьи, акции и объявления компании
                            </div>
                        </div>


                        <div class="items-row cols-1 row-0 row-fluid clearfix">
                            <div class="span12">
                                <div class="item column-1" itemprop="blogPost" itemscope=""
                                     itemtype="https://schema.org/BlogPosting">


                                    <dl class="article-info muted">


                                        <dt class="article-info-term">
                                        </dt>


                                        <dd class="published">
                                            <span class="icon-calendar" aria-hidden="true"></span>
                                            <time datetime="2021-10-21T09:08:16+00:00" itemprop="datePublished">
                                                <span class="date-day">21</span><span class="datefull">/10.2021</span>
                                            </time>
                                        </dd>
                                    </dl>


                                    <div class="page-header">
                                        <div class="blog-title">
                                            <a href="/novosti/20-eto-tekst-o-kompanii-on-neobkhodim-dlya-dalnejshego-prodvizheniya-vashego-sajta"
                                               itemprop="url">Это текст о компании. Он необходим для дальнейшего
                                                продвижения Вашего сайта.</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- end item -->
                            </div><!-- end span -->
                        </div><!-- end row -->
                        <div class="items-row cols-1 row-1 row-fluid clearfix">
                            <div class="span12">
                                <div class="item column-1" itemprop="blogPost" itemscope=""
                                     itemtype="https://schema.org/BlogPosting">

                                    <dl class="article-info muted">

                                        <dt class="article-info-term">
                                        </dt>

                                        <dd class="published">
                                            <span class="icon-calendar" aria-hidden="true"></span>
                                            <time datetime="2021-10-21T09:08:16+00:00" itemprop="datePublished">
					<span class="date-day">
					    21					</span>
                                                <span class="datefull">
					    /10.2021					</span>
                                            </time>
                                        </dd>


                                    </dl>


                                    <div class="page-header">
                                        <div class="blog-title">
                                            <a href="/novosti/21-eto-tekst" itemprop="url">
                                                Это текст о компании. </a>
                                        </div>


                                    </div>


                                </div>
                                <!-- end item -->
                            </div><!-- end span -->
                        </div><!-- end row -->
                        <div class="items-row cols-1 row-2 row-fluid clearfix">
                            <div class="span12">
                                <div class="item column-1" itemprop="blogPost" itemscope=""
                                     itemtype="https://schema.org/BlogPosting">


                                    <dl class="article-info muted">


                                        <dt class="article-info-term">
                                        </dt>


                                        <dd class="published">
                                            <span class="icon-calendar" aria-hidden="true"></span>
                                            <time datetime="2021-10-21T09:08:16+00:00" itemprop="datePublished">
					<span class="date-day">
					    21					</span>
                                                <span class="datefull">
					    /10.2021					</span>
                                            </time>
                                        </dd>


                                    </dl>


                                    <div class="page-header">
                                        <div class="blog-title">
                                            <a href="/novosti/22-on-neobkhodim-dlya-dalnejshego-prodvizheniya-vashego-sajta"
                                               itemprop="url">
                                                Он необходим для дальнейшего продвижения Вашего сайта. </a>
                                        </div>


                                    </div>


                                </div>
                                <!-- end item -->
                            </div><!-- end span -->
                        </div><!-- end row -->


                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
