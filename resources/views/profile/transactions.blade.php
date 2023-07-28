@extends('layouts.app',[
    'title'=>'Мои посылки',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Мои посылки'
    ],
])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">

        <div class="mb-50px">
            <div class="title adress-count">
                Транзакции
            </div>
            <p class="sub-adress">Список проведенных транзакций</p>
        </div>

        <div class="transact-nav mb-50px">
            <a href="{{ route('profile.transactions') }}" class="transact-link {{ request('outgo',-1)<0?'active':'' }}">Все</a>
            <a href="{{ route('profile.transactions', ['outgo'=>0]) }}"
               class="transact-link {{ request('outgo',-1)==0?'active':'' }}">Приход</a>
            <a href="{{ route('profile.transactions', ['outgo'=>1]) }}"
               class="transact-link {{ request('outgo',-1)==1?'active':'' }}">Расход</a>
        </div>

        <div class="transact-flex">
            <div class="transact-left balance-flex flex flex-wrap between align-center mb-50px hide">
                <div class="title20">Баланс: {{ Auth::user()->balance }}$</div>

                <a href="{{ route('profile.balance') }}" class="replenish bt btn-orange">пополнить счет</a>
            </div>
            <div class="table-block">
                <table class="table transact">
                    <thead>
                    <tr>
                        <td>Сумма ($)</td>
                        <td>Тип</td>
                        <td>Дата</td>
                        <td>Комментарии</td>
                        <td>Подтвержден</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->count }}</td>
                            <td>{{ $item->outgo?'Расход':'Приход' }}</td>
                            <td>{{ $item->created_at->format('d.m.Y') }}</td>
                            <td></td>
                            <td>{{ $item->created_at->format('d.m.Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
