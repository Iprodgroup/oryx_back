@extends('layouts.main')

@section('meta')
    <title>{{ $data['title'] }}</title>
    <meta name="description" content="{{ $data['description'] }}">
@endsection

@section('content')


    <div class="container">
        <div style="margin-top: 150px">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="/populyarnye-magaziny">Популярные</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $store->name }}</li>
                </ol>
            </nav>
            <h1>{{ $data['h1'] }}</h1>

            <br>
            <br>
            <br>

            <div>
                <div id="lightbox"></div>
            </div>
            <img class="zoomD" width="350px" src="/storage/{{ $store->img }}" alt="{{ $store->alt }}" title="{{ $store->title }}">
            <br>
            <br>

            {!! $store->short_desc !!}

            <br><br>


            <div>
                <a href="{{ $store->link }}" title="{{ $store->title }}">
                    <button class="btn btn-red">перейти на Сайт</button>
                </a>
            </div>

            <br>
            <br>
            <br>

            {!! $store->description !!}

            <br>
            <br>
        </div>
    </div>

@endsection

@section('styles')

    <style>
        /* (A) LIGHTBOX BACKGROUND */
        #lightbox {
            position: fixed; z-index: 999;
            top: 0; left: 0;
            width: 100vw; height: 100vh;

            /* (A2) BACKGROUND */
            background: rgba(0, 0, 0, 0.5);

            /* (A3) CENTER IMAGE ON SCREEN */
            display: flex;
            align-items: center;

            /* (A4) HIDDEN BY DEFAULT */
            visibility: hidden;
            opacity: 0;

            /* (A5) SHOW/HIDE ANIMATION */
            transition: opacity ease 0.4s;
        }

        /* (A6) TOGGLE VISIBILITY */
        #lightbox.show {
            visibility: visible;
            opacity: 1;
        }

        #lightbox img {
            width: fit-content;
            height: 100vh;
            object-fit: fill;
            object-position: center center;
            margin: auto;
        }

        .zoomD {
            cursor: pointer;
        }
</style>
@endsection

@section('scripts')
    <script>
        window.onload = () => {
            // (A) GET LIGHTBOX & ALL .ZOOMD IMAGES
            let all = document.getElementsByClassName("zoomD"),
                lightbox = document.getElementById("lightbox");

            // (B) CLICK TO SHOW IMAGE IN LIGHTBOX
            // * SIMPLY CLONE INTO LIGHTBOX & SHOW
            if (all.length>0) { for (let i of all) {
                i.onclick = () => {
                    let clone = i.cloneNode();
                    clone.className = "";
                    lightbox.innerHTML = "";
                    lightbox.appendChild(clone);
                    lightbox.className = "show";
                };
            }}

            // (C) CLICK TO CLOSE LIGHTBOX
            lightbox.onclick = () => lightbox.className = "";
        };
    </script>
@endsection
