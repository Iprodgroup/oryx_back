@extends('layouts.main')

@section('meta')
    <meta name="description" content="Заказывайте товары из США с доставкой в Казахстан от 7 дней! Оплачивайте любым удобным для Вас способом. Приглашайте друзей, получайте бонусы.">
@endsection

@section('content')

    @include('blocks.block1')
    <section class="block1">
        <div class="moduletable">

            <div class="custom">
                <div class="container">

                    <div class="about about1 flex flex-wrap between align-center mb-50px" style="max-width: 1085px">

                        <div class="about-img wow fadeInLeft" data-wow-offset="25" data-wow-duration="1.5s" style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInLeft;">
                            <img src="/images//site/about1.jpg" alt="about">
                        </div>

                        <div class="about-item wow fadeInRight" style="max-width: 510px; visibility: visible; animation-duration: 1.5s; animation-name: fadeInRight;" data-wow-offset="25" data-wow-duration="1.5s">

                            <div class="title about-title">
                                Как заказать доставку посылки из США?
                            </div>
                            <div class="text about-text">
                                <p>Хотите экономить до 80% на шопинге от популярных и люксовых брендов?</p>
                                <p>Покупайте в США одежду, обувь, гаджеты, игрушки со скидками. Выполните три простых шага, чтобы получить покупку из США.</p>
                            </div>
                            <a href="#aboutslider" class="bt scroll-down">

                                <div class="animated bounce delay-3s infinite">
                                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.52922 13.5318C7.91975 13.9223 8.55291 13.9223 8.94343 13.5318L15.3074 7.16785C15.6979 6.77733 15.6979 6.14416 15.3074 5.75364C14.9169 5.36312 14.2837 5.36312 13.8932 5.75364L8.23633 11.4105L2.57947 5.75364C2.18895 5.36311 1.55578 5.36311 1.16526 5.75364C0.774736 6.14416 0.774736 6.77733 1.16526 7.16785L7.52922 13.5318ZM7.23633 0.581543L7.23633 12.8247L9.23633 12.8247L9.23633 0.581543L7.23633 0.581543Z" fill="#222222"></path>
                                    </svg>
                                </div>
                            </a>

                        </div>

                    </div>

                </div></div>
        </div>

    </section>
    @include('blocks.block2')
    <section id="main">
        <div id="content" class="container">
            <div class="jr_component">
                <div class="jr_full">
                    <div id="system-message-container"></div>
                    <div class="blog-featured" itemscope="" itemtype="https://schema.org/Blog"></div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>
    @include('blocks.block3')
    @include('blocks.block5')
    @include('blocks.block6')
    @include('blocks.block7')
@endsection
