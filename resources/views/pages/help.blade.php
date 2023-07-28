@extends('layouts.main')

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
                            <div class="about about1 flex flex-wrap between align-center mb-150px"
                                 style="max-width: 1085px;margin-left: 0;">

                                <div class="about-img about-img_anim">
                                    <div class="list list2"></div>
                                    <img src="/images/site/box3.png" class="box box3">
                                    <img src="/images/site/box4.png" class="box box4">
                                    <img src="/images/site/aero.png" class="aero">
                                </div>

                                <div class="about-item" style="max-width:510px">

                                    <h1 class="title about-title">
                                        Условия сервиса и стоимость
                                    </h1>
                                    <div class="text about-text">
                                        <p>Компания ORYX – является мэйлфорвард сервисом, который предоставляет каждому
                                            клиенту бесплатный адрес в США в безналоговом штате для приема, хранения и
                                            дальнейшей отправки Ваших покупок.</p>
                                        <p>Для нас нет невыполнимых задач в сфере шопинга и доставки из США! Сделать
                                            фото, проверить размеры, вернуть товар в магазин или поменять его? Легко!
                                            Стоимость таких спецзапросов определяется отдельно и зависит от их
                                            сложности. По всем вопросам обращайтесь к менеджерам, которые с радостью Вас
                                            проконсультируют.</p>
                                    </div>
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
