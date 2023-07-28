@extends('layouts.app',[
    'title'=>'Настройки аккаунта',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Мои уведомления'
    ],
])

@section('content')

    <x-profileNav></x-profileNav>


    <div class="container">


        <div class="mb-50px">
            <div class="title adress-count">
                Мои уведомления
            </div>
            <p class="sub-adress">Уведомления о действиях на сайте</p>
        </div>

        <div class="notif">

            <div class="notif-nav flex flex-wrap between align-center  mb-50px">
                <div class="notif-links  transact-nav">
                    <a class="transact-link {{ request()->input('read')?'':'active' }}"
                       href="{{ route('profile.notifications') }}">Все уведомления</a>
                    <a class="transact-link {{ request()->input('read')?'active':'' }}"
                       href="{{ route('profile.notifications', ['read'=>1]) }}">Непрочитанные
                        <span>{{ $read }}</span></a>
                </div>


                <div class="mark-all">
                    <form>
                        <a href="{{ route('profile.notificationsr') }}" class="bt btn-orange mark-button">
                            <svg width="27" height="25" viewBox="0 0 27 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M23.9154 24.9547H8.40031C6.97464 24.9547 5.81445 23.7761 5.81445 22.3278V11.8203C5.81445 10.372 6.97464 9.19336 8.40031 9.19336H23.9154C25.3411 9.19336 26.5013 10.372 26.5013 11.8203V22.3278C26.5013 23.7761 25.3411 24.9547 23.9154 24.9547ZM8.40031 23.2035H23.9154C24.3904 23.2035 24.7774 22.8112 24.7774 22.3278V11.998L16.6992 18.6301C16.5414 18.7605 16.3501 18.8253 16.1579 18.8253C15.9656 18.8253 15.7743 18.7605 15.6166 18.6301L7.53835 11.998V22.3278C7.53835 22.8112 7.92537 23.2035 8.40031 23.2035ZM23.3189 10.9446H8.99677L16.1579 16.8236L23.3189 10.9446Z"
                                      fill="#DC1E52"/>
                                <rect x="0.455078" y="0.888672" width="14.2561" height="12.1011" rx="4" fill="#DC1E52"/>
                                <path d="M4.78516 5.74551L7.40723 9.69803L10.3813 4.18018" stroke="white"
                                      stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Отметить все как прочитанное</a>
                    </form>
                </div>
            </div>

            <div class="notif-block">
                @foreach ($items as $item)
                    <a href="{{ route('profile.notification', $item->id) }}" class="notif-flex whitebox"
                       style="margin-bottom: 20px;display: block;">
                        <div class="notif-type">{{ $item->title }}</div>
                        <div class="notif-date">{{ $item->created_at->format('d.m.Y, H:m') }}</div>
                    </a>
                @endforeach
            </div>
        </div>


    </div>

@endsection
