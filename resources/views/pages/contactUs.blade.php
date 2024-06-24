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
                    <li class="breadcrumb-item active" aria-current="page">Контакты</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="item-page" itemscope="" itemtype="https://schema.org/Article">
                        <meta itemprop="inLanguage" content="ru-RU">

                        <div itemprop="articleBody">
                            <div class="contact-wrap flex flex-wrap mb-100px">

                                <div class="contact-box col-md-5">
                                    <h1 class="title contact-title">{{ $data['h1'] }}</h1>
                                    <div class="text pl-15px mb-30px">{{ $data['text'] }}</div>

                                    <div class="contact">

                                        @foreach($contacts as $contact)
                                            @if($contact->options === 'div')
                                                <div class="contact-item">
                                                    <div class="contact-head">{{ $contact->title}}</div>
                                                    <div>{{ $contact->txt }}</div>
                                                </div>
                                            @endif
                                            @if($contact->options !== 'div')
                                                    <div class="contact-item">
                                                        <div class="contact-head">{{ $contact->title}}</div>
                                                        <div>
                                                            <a href="{{ $contact->link }}">{{ $contact->txt }}</a>
                                                        </div>
                                                    </div>
                                            @endif
                                        @endforeach


                                    </div>

                                </div>
                                <div class="map col-md-7">
                                    <div style="position:relative;overflow:hidden; height:100%"><a href="https://yandex.uz/maps/162/almaty/?utm_medium=mapframe&amp;utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Алматы</a><a href="https://yandex.uz/maps/162/almaty/house/Y08YfwVlT0cGQFppfX53c3ViZA==/?indoorLevel=1&amp;ll=76.925622%2C43.262910&amp;utm_medium=mapframe&amp;utm_source=maps&amp;z=16.87" style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Макатаева, 125 — Яндекс&nbsp;Карты</a><iframe src="https://yandex.uz/map-widget/v1/?indoorLevel=1&amp;ll=76.925622%2C43.262910&amp;mode=search&amp;ol=geo&amp;ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg2NzMwMDE5NhJE0prQsNC30LDSm9GB0YLQsNC9LCDQkNC70LzQsNGC0YssINCc0LDSm9Cw0YLQsNC10LIg0LrTqdGI0LXRgdGWLCAxMjUiCg3r2ZlCFTkNLUI%2C&amp;z=16.87" allowfullscreen="true" style="position:relative;" width="560" height="600" frameborder="1"></iframe></div>
                                    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.014778422501!2d76.96439021574598!3d43.25111207913719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38836e5f052d8723%3A0x2fc8d9ced52fbf50!2z0YPQuy4g0JrQsNCx0LDQvdCx0LDQuSDQsdCw0YLRi9GA0LAgMTAsINCQ0LvQvNCw0YLRiyAwNTAwMTA!5e0!3m2!1sru!2skz!4v1654498839571!5m2!1sru!2skz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                                </div>

                            </div>	</div>


                    </div>

                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection
