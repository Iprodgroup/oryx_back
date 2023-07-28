@extends('layouts.app',[
    'title'=>'Личный кабинет',
    'breadcrumbs'=>[
        url()->current()=>'Личный кабинет'
    ],
])



@section('content')

    <x-profileNav></x-profileNav>

    @if (\Session::has('instead'))
        <div class="container">
            <div class="alert alert-success">
                <p>Запрос отправлен</p>
            </div>
        </div>
    @endif
	<div class="container">

	    <div class="account-blocks flex flex-wrap">
            <div class="acc-card whitebox mb-30px flex flex-wrap" style="width: 100%;">
                <div class="avatar">
                    <img src="/images/avatar.jpg">
                </div>
                <div class="acc-data">
                    <div class="acc-name title20">
                        {{ Auth::user()->name }} {{ Auth::user()->surname }}
                    </div>
                    <div class="userid flex flex-wrap">
                        <p class="first-id">ID:</p>
                        <p class="item-id">#{{ Auth::user()->id }}</p>
                    </div>
                    <div class="usermail flex flex-wrap">
                        <p class="first-id">Email:</p>
                        <p class="item-id">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="userphone flex flex-wrap">
                        <p class="first-id">Телефон:</p>
                        <p class="item-id">{{ Auth::user()->p }}</p>
                    </div>
                    <div class="view-all">
                        <a href="{{ route('profile.settings') }}">Посмотреть все данные</a>
                    </div>

                @if ((Auth::user()->tariffObj->code ?? '')!='default')
                	<div class="vip-status">VIP</div>
                @endif
                </div>
            </div>
            <div class="my-parcels  whitebox mb-30px" style="width: 100%;">
                <div class="acc-name title20">Мои посылки</div>
                <p class="sub-text">Просмотр статуса и добавление новых посылок</p>
                <p class="parcels-active">Активных посылок ({{ Auth::user()->parcelActiveCount() }})</p>
                <div class="view-all">
                    <a href="{{ route('profile.parcels') }}">Узнать подробнее</a>
                </div>
            </div>
            <div class="transaction  whitebox mb-30px" style="width: 100%;">
                <div class="acc-name title20">Транзакции</div>
                <p class="sub-text">История совершенных транзакций</p>
                <div class="view-all">
                    <a href="{{ route('profile.transactions') }}">Узнать подробнее</a>
                </div>
            </div>
        </div>

	</div>

@endsection


