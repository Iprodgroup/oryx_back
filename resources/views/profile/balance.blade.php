@extends('layouts.app',[
    'title'=>'Настройки аккаунта',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Пополнить баланс'
    ],
])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">
        @if (Session::has('order_error'))
            <div class="alert alert-info">Ошибка при формировании платежа</div>
        @endif
        @if (Session::has('order_return_error'))
            <div class="alert alert-info">Ошибка при проверке платежа</div>
        @endif
        <div class="schet">
            <p class="schet-head"><b>Ваш текущий баланс {{ Auth::user()->balance }}$</b></p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('profile.balance') }}">
                @csrf
                <div class="schet-in">
                    <input type="text" id="usd_count" name="count" value="10" placeholder="Введите сумму"
                           class="style-input schet-input" autocomplete="off"/>
                    <a href="{{ route('profile.balance') }}" class="replenish bt btn-orange">пополнить счет</a>
                </div>
                <p class="tenge">₸ <span id="tenge_count">{{ number_format($currency*11,'2',',',' ') }}</span></p>
            </form>
            <p><a href="/soglasheni" target="_blank">Соглашение</a></p>
        </div>

    </div>

@endsection
@section('script')
    <script>
        $(function () {
            var currency = {{ $currency }};
            $('#usd_count').keyup(function () {
                $(this).val($(this).val().replace(',', '.'));
                $('#tenge_count').html(new Intl.NumberFormat().format($(this).val() * currency));
            });
        });
    </script>
@endsection
