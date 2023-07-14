@extends('layouts.main')

@section('content')

    <section id="main" style="padding-top: 170px;">
        <div class="container">
            <div class="moduletable">

                <div class="custom">
                    <div class="title joomcathead">
                        Популярные магазины в США
                    </div>
                    <div class="text mb-50px" style="max-width: 650px;">
                        Мы подготовили для вас список самых популярных магазинов одежды, которые диктуют тренды каждого
                        сезона
                    </div>
                </div>
            </div>
        </div>

        <div id="content" class="container">
            <div class="jr_component">
                <div class="jr_left">

                </div>
                <div class="jr_middle">

                    <div id="system-message-container">
                    </div>

                    <div class="jshop productfull" id="comjshop">
                        <form name="product" method="post" action="" enctype="multipart/form-data" autocomplete="off">

                            <h1>{{ $store->name }}</h1>

                            <div class="row-fluid jshop">
                                <div class="span4 image_middle">

                <span id="list_product_image_middle">
                    <a class="lightbox" id="main_image_full_300" href="/storage/{{ $store->img }}" title="{{ $store->title }}">
                            <img width="350px" src="/storage/{{ $store->img }}" alt="Amazon" title="{{ $store->title }}">
                        <br>
                        <br>
                            <div class="text_zoom"><img src="https://orix.kz/components/com_jshopping/images/search.png" alt="zoom">Увеличить изображение</div></a></span></div>
                                <div class="span8 jshop_img_description">
                                    <span id="list_product_image_thumb"></span>
                                </div>
                            </div>

                            <br>
                            <div class="jshop_prod_description">
                                {!! $store->short_desc !!}<br><br>
                                Сайт: <a href="{{ $store->link }}" target="_blank">{{ $store->link }}</a>
                            </div>

                            <div class="old_price" style="display:none">
                                Старая цена:<span class="old_price" id="old_price">0.00 EUR</span>
                            </div>

                            <br>

                            <div class="extra_fields">
                                <div class="block_efg">
                                    <div class="extra_fields_group"></div>

                                    <div class="extra_fields_el">
                                        <span class="extra_fields_name">Категории</span>:
                                        <span class="extra_fields_value">Популярные магазины, Одежда и обувь, Товары для детей, Электроника и фототехника, Косметика, Товары для дома                    </span>
                                    </div>

                                </div>
                            </div>

                            <br>
                            <br>

                            <input type="hidden" name="to" id="to" value="cart">
                            <input type="hidden" name="product_id" id="product_id" value="278">
                            <input type="hidden" name="category_id" id="category_id" value="1">
                        </form>


                        <div id="list_product_demofiles"></div>


                    </div>
                    <span id="mxcpr">Copyright MAXXmarketing GmbH<br><a rel="nofollow" target="_blank"
                                                                        href="https://www.joomshopping.com/">JoomShopping Download &amp; Support</a></span>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="shopseo flex flex-wrap mb-100px">

            <div class="title shopseo-title">
                Что чаще всего покупают в США?
            </div>

            <div class="text shopseo-item">
                Сейчас огромной популярностью пользуются интернет-магазины в США. В
                Америке можно купить все, что угодно от одежды, бытовой техники и даже
                автомобильных запчастей. На покупке оригинальных брендов Вы сэкономите
                20-40% её офлайн стоимости, а на скидках можно сэкономить до 80-90%,
                учитывая доставку. Помимо экономии, интернет-шоппинг в США отличается
                огромным разнообразием ассортимента и эксклюзивных коллекций, которые
                редко найдёшь в нашей стране.

            </div>


        </div>
    </div>

@endsection
