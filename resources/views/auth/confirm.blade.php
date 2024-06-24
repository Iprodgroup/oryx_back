@extends('layouts.app',[
    'title'=>'Подтверждение',
    'breadcrumbs'=>[
    url()->current()=>'Подтверждение'
    ],
])

@section('content')

<div class="container">

    <div class="confirm-flex flex flex-wrap align-center">
        <img src="/storage/images/regconfirm.png" class="confirm-img">
        <div class="confirmed-mail">
            <div class="confirm-head">Благодарим вас за подтверждение вашего электронного адреса!</div>
            <p class="sub-conf">Для того, чтобы завершить процесс регистрации на сайте, заполните пожалуйста следующие поля.</p>
            <form method="POST" action="{{ route('register.confirm') }}">
                @csrf
                <div class="inputs-confirm">
                    @foreach (['name'=>'Имя','surname'=>'Фамилия','email'=>'Email','phone'=>'Телефон'] as $name=>$ph)
                        @if (!$item->{$name})
                            <input type="text" name="{{ $name }}" placeholder="{{ $ph }}{{ $name=='fname'?'':'*' }}" value="{{ old($name) }}" {{ $name=='fname'?'':'required' }} />
                        @endif
                    @endforeach

                    <button type="submit" class="bt btn-orange">Завершить регистрацию</button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
