@extends('layouts.main')

@section('content')

    {{--@include('blocks.block1')
    @include('blocks.block2')--}}
    <section id="main">
        <br>
        <br>
        <br>
        <br>
        <br>
        <img style="width: 50%; margin: auto; display: block" src="{{ asset ('/storage/icons/404.png') }}" alt="object not found">
        <br>
        <b><p style="font-size: 25px; text-align: center; color: #ff4330">Извините, мы не можем найти эту страницу</p></b>
        <br>
        <div class="" style="width: 200px; display: flex; align-items: center; flex-direction: column; margin: auto">
            <a class="btn btn-orange" href="/">главная</a>
        </div>
        <br>
        <br>
    </section>
    {{--@include('blocks.block3')--}}
    {{--@include('blocks.block5')--}}
    {{--@include('blocks.block6')--}}
    {{--@include('blocks.block7')--}}
@endsection
