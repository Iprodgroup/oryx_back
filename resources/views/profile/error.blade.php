@extends('layouts.app',[
    'title'=>'Настройки аккаунта',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Оплата'
    ],
])

@section('content')
    <div class="container">
        <div class="schet">
            <p class="schet-head">При оплате позвникла ошибка, либо платеж был отменен.</p>
        </div>
    </div>
@endsection
