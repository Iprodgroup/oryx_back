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
                    <li class="breadcrumb-item active" aria-current="page">Купите вместо меня</li>
                </ol>
            </nav>

            <div class="jr_component">
                <div class="jr_full">

                    <div id="system-message-container">
                    </div>

                    <div class="item-page">
                        <meta itemprop="inLanguage" content="ru-RU">

                        <div itemprop="articleBody">
                            <h1 class="title page-title">{{ $data['h1'] }}</h1>

                            <br>
                            <br>

                            <div class="instructions row between">
                                <div class="col-12 col-md-2 instruction-box tc">
                                    <div class="circle dib pr"
                                         style="background-image: url('{{ asset('assets/images/link_icon.svg') }}');">
                                        <div class="step pa tc">1</div>
                                    </div>
                                    <p class="mt--10">Отправьте нам ссылку</p>
                                </div>
                                <div class="d-none d-md-block arrow tc">
                                    <svg class="arrow-right" xmlns="http://www.w3.org/2000/svg" width="145" height="16"
                                         viewBox="0 0 145 16">
                                        <path id="arrow_right"
                                              d="M113.157,0l-.5.771,9.853,6.747H-20v.964H122.512l-9.853,6.747.5.771L125,8Z"
                                              transform="translate(20)" fill="#acacac"></path>
                                    </svg>
                                </div>
                                <div class="col-12 col-md-2 instruction-box tc">
                                    <div class="circle dib pr"
                                         style="background-image: url( '{{ asset('assets/images/shop_icon.svg') }}');">
                                        <div class="step pa tc">2</div>
                                    </div>
                                    <p class="mt--10">Мы осуществим покупку.</p>
                                </div>
                                <div class="d-none d-md-block  arrow tc">
                                    <svg class="arrow-right" xmlns="http://www.w3.org/2000/svg" width="145" height="16"
                                         viewBox="0 0 145 16">
                                        <path id="arrow_right"
                                              d="M113.157,0l-.5.771,9.853,6.747H-20v.964H122.512l-9.853,6.747.5.771L125,8Z"
                                              transform="translate(20)" fill="#acacac"></path>
                                    </svg>
                                </div>
                                <div class="col-12 col-md-2 instruction-box tc">
                                    <div class="circle dib pr"
                                         style="background-image: url('{{ asset('assets/images/globe_icon.svg') }}');">
                                        <div class="step pa tc">3</div>
                                    </div>
                                    <p class="mt--10">Получи посылку в Казахстане</p>
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="row" style="background-color: #fafafa; padding-bottom: 25px; border-radius: 15px;">
                                <div class="col-md-12 col-sm-12">
                                    <div style="padding-top: 15px;" class="subscribe-edit">
                                        <form action="/buy" method="post" class="subscribe-form"
                                              novalidate="novalidate">
                                            <div class="flex flex-column">
                                                @csrf
                                                <table id="tblAppendGrid"></table>

                                                <div class="flex justify-content-end" style="margin-top: 30px">
                                                    <input id="num"
                                                           style="margin-right: -130px; font-size: 20px; width: 350px; padding: 23px; padding-right: 60px; border-radius: 25px;"
                                                           size="10" type="tel" maxlength="255" name="number"
                                                           class="form-control subscribe-input required"
                                                           placeholder="введите номер" required="required"
                                                           aria-required="true" pattern="[0-9()#&amp;+*-=.]+"
                                                           title="Only numbers and phone characters (#, -, *, etc) are accepted.">
                                                    <button type="submit" class="btn buy-remove buy-submit">Отправить
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <style>
                                    .buy-remove[data-unique-index="3"] {
                                        display: none;
                                    }
                                </style>
                            </div>

                            <br>
                            <br>
                            <div class="row">
                                <div class="buy-options col-lg-5 flex align-center">
                                    <img width="60px" src="{{ asset('/assets/images/options.svg') }}" alt="options">
                                    <p style="margin-left: 15px; margin-top: 15px;"><b>Условия сервиса</b></p>
                                </div>
                                <div class="buy-options col-lg-7">Скопируйте ссылку на товар из интернет-магазина и
                                    вставьте его на нашей странице «Купи вместо меня». Затем необходимо указать детали
                                    заказа (количество, цвет, размер и т. д.) и оплатить покупку. Мы попытаемся
                                    совершить покупку в течение 1 раб. дня. Для декларирования посылки основанием
                                    послужит инвойс, который выдает магазин. После совершения покупки, декларированная
                                    цена товара не подлежит изменению. В случае возникновения вопросов звоните пн - пт
                                    11:30 - 15:30.
                                </div>

                                <div class="buy-options col-lg-5 flex align-center">

                                    <img width="60px" src="{{ asset('/assets/images/price.svg') }}" alt="price">
                                    <p style="margin-left: 15px; margin-top: 15px;"><b>Стоимость услуги </b></p>
                                </div>
                                <div class="buy-options col-lg-7">Стоимость услуги составляет 7% от общей стоимости
                                    заказа (мин. 7$). В случае специальных магазинов, дополнительно 7% (мин. 7$)
                                    взимается за каждую ссылку.
                                </div>

                                <div class="buy-options col-lg-5 flex align-center">
                                    <img width="60px" src="{{ asset('/assets/images/special_shop.svg') }}" alt="shop">
                                    <p style="margin-left: 15px; margin-top: 15px;"><b>Специальные магазины</b></p>
                                </div>
                                <div class="buy-options col-lg-7">Есть ряд магазинов, которые не доставляют на адреса
                                    складов. Для покупки из данных магазинов необходимо воспользоваться услугой
                                    транспортировки от нашего партнера.
                                </div>

                                <style>
                                    .buy-options {
                                        margin-bottom: 40px;
                                    }
                                </style>
                            </div>
                            <br>
                            <br>

                            <div class="row" style="background-color: #fafafa; padding-top: 25px; border-radius: 15px;">

                                <div class="buy-items col-md-4 flex flex-column align-center">
                                    <img width="60px" src="{{ asset('/assets/images/card_icon.svg') }}" alt="card">
                                    <p style="text-align: center; margin-top: 15px;"><b>Покупки при отсутствии банковской карты</b></p>
                                </div>

                                <div class="buy-items col-md-4 flex flex-column align-center">
                                    <img width="60px" src="{{ asset('/assets/images/time_icon.svg') }}" alt="time">
                                    <p style="text-align: center; margin-top: 15px;"><b>Экономия времени</b></p>
                                </div>

                                <div class="buy-items col-md-4 flex flex-column align-center">
                                    <img width="60px" src="{{ asset('/assets/images/special_card_icon.svg') }}" alt="special">
                                    <p style="text-align: center; margin-top: 15px;"><b>Покупки в специальных магазинах через американскую карту</b></p>
                                </div>

                                <style>
                                    .buy-items{
                                        margin-bottom: 25px;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery.appendgrid@2/dist/AppendGrid.js"></script>

    <script>
        var myAppendGrid = new AppendGrid({
            element: "tblAppendGrid",
            columns: [
                {
                    name: "link",
                    ctrlAttr: {
                        placeholder: "Скопируйте ссылку из магазина и вставьте сюда",
                        class: "buy-link-input form-control",
                        size: "40"
                    }
                },
                {
                    name: "product-info",
                    ctrlAttr: {
                        placeholder: "Характеристики",
                        class: "buy-link-input form-control",
                        size: "23"
                    }
                },
                {
                    name: "product-name",
                    ctrlAttr: {
                        placeholder: "Введите имя товара",
                        class: "buy-link-input form-control",
                        size: "13"
                    }
                }
            ],
            hideButtons: {
                // Hide the move up and move down button on each row
                moveUp: true,
                moveDown: true,
                insert: true,
                removeLast: true
            },
            sectionClasses: {
                append: "buy-btn",
                remove: "buy-remove",

            }
        });

        myAppendGrid.removeRow(0);
        myAppendGrid.removeRow(0);

        $('.buy-btn').html(' + <span class="buy-span">Добавить еще одну покупку<span> ')
            .attr('placeholder', 'Скопируйте ссылку из магазина и вставьте сюда');
    </script>
@endsection
@section('styles')
    <style>
        .buy-btn {
            font-size: 35px;
            font-weight: bold;
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: #e65a57;
        }

        .buy-btn span {
            font-size: 18px;
            margin-top: 5px;
            margin-left: 5px;
        }

        .buy-link-input {
            font-size: 16px;
            padding: 12px;
            border-radius: 25px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .buy-remove {
            border-radius: 25px;
            background-color: #e65a57;
            color: white;
            padding: 5px 10px;
            border: none;
        }

        .buy-submit {
            padding: 10px 25px;
        }

        .circle {
            background-color: #fafafa;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 100%;
            height: 89px;
            width: 89px;
        }

        .circle .step {
            background-color: #34b78f;
            border-radius: 100%;
            color: #fff;
            height: 23px;
            bottom: 0;
            left: 0;
            line-height: 22px;
            width: 23px;
        }

        .pr {
            position: relative;
        }

        .tc {
            text-align: center;
            border: 0;
            font: inherit;
            margin: 0;
            padding: 0;
            align-items: center;
            display: flex;
            flex-direction: column;
        }

        .mt--10 {
            margin-top: 10px;
        }

        .arrow {
            padding-top: 36px;
        }

        .dn {
            display: none;
        }

        table tbody td:nth-child(1) {
            display: none;
        }

        table {
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            table-layout: fixed;
        }

        thead {
            display: none;
        }

        table tr:last-child {
            border: none;
        }

        @media screen and (max-width: 992px) {

            .buy-link-input {
                width: 100%;
                /*width: 500px;*/
            }

            table tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;
                padding-bottom: 20px;
                border-bottom: 10px solid rgba(0, 0, 0, 0.07);
                border-radius: 30px;
            }

            table td:nth-child(3n - 2) {
                width: 200px;
            }

            table td:nth-child(3n) {
            }

            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }

        }


    </style>
@endsection
