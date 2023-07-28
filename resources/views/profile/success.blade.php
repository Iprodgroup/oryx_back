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
            @if ($res['OrderStatus']==2)
                Платеж прошел успешно - посылка оплачена.
            @else
                Платеж ещё проверяется.
            @endif
        </div>
    </div>
@endsection
