@extends('layouts.main')

@section('meta')
    <title>{{ $data['title'] }}</title>
    <meta name="description" content="{{ $data['description'] }}">
@endsection()

@section('content')

    <section id="main" style="padding-top: 170px;">

        <div class="container">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Популярные</li>
                </ol>
            </nav>

            <div class="moduletable">
                <div class="custom">
                    <h1>{{ $data['h1'] }}</h1>
                    <br>
                    <div class="text mb-50px" style="max-width: 650px;">{{ $data['subtitle'] }}</div>
                </div>
            </div>

        </div>

        <div id="content" class="container">
            <div class="jr_component">
                <div class="jr_left">
                    <div class="moduletable">
                        <script type="text/javascript">
                            function modFilterclearPriceFilter() {
                                var $form = jQuery('.jshop_filters form[name=jshop_filters]');
                                if ($form.length) {
                                    $form.find('input[type=text]').val('');
                                    $form.find('input[type=checkbox]').prop('checked', false);
                                    document.jshop_filters.submit();
                                }
                            }
                        </script>
                        <div class="jshop_filters">
                            <form action="/populyarnye-magaziny" method="post" name="jshop_filters">


                                <div class="filter_characteristic">

                                    <div class="filter-name">Категории</div>
                                    @csrf
                                    @foreach($categories as $category)
                                        <div class="filgroup">
                                            <input type="checkbox" name="extra_fields[]" value="{{ $category->id }}" onclick="document.jshop_filters.submit();"
                                                {{ in_array($category->id, $selects) ? 'checked' : ''}}>
                                            <p class="filval">{{ $category->name }}</p>
                                        </div>
                                    @endforeach

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="jr_middle">

                    <div id="system-message-container">
                    </div>

                    <div class="jshop" id="comjshop">
                        <div class="jshop_list_product">
                            <div class="row" id="comjshop_list_product">

                                @foreach($stores as $store)
                                    <div class="shopitem col-lg-4 col-xl-3 col-md-4 col-sm-6 col-">

                                        <div class="shopname">
                                            <div>
                                                {{ $store->name }}
                                            </div>
                                        </div>

                                        <div class="image">

                                            <a href="/populyarnye-magaziny/{{ $store->slug }}">
                                                <img class="jshop_img" src="storage/{{ $store->img }}" alt="{{ $store->alt }}" title="{{ $store->title }}">
                                            </a>

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                            {{ $stores->links() }}
                            <br>
                            <br>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="shopseo flex flex-wrap mb-100px">

            <div class="title shopseo-title">
                Что чаще всего покупают в США?
            </div>

            <div class="text shopseo-item">{{ $data['text'] }}</div>


        </div>
    </div>

@endsection
