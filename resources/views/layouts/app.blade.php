<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="og:image" content="{{ asset('/images/site/logo.png') }}">
    <meta name="og:title" content=''>
    <meta name="og:description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/site/favicon.png" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css?v=1') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    <style>
        .callBack {
            position: fixed;
            bottom: 110px;
            right: 25px;
            z-index: 999;
        }

        .callBack__body {
            position: relative;
        }

        .callBack__icon {
            width: 50px;
            height: 50px;
            cursor: pointer;
            position: relative;
            z-index: 0;
            transition: 1.3 ease-in-out;
        }

        .callBack__icon:hover {
            transform: scale(1.1);
        }

        .callBack__icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border: 1px solid #FF782D;
            border-radius: 50%;
            animation: pulse 1.1s linear infinite;
        }

        .callBack__icon::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border: 1px solid #FF782D;
            border-radius: 50%;
            animation: pulse 2.1s linear infinite;
        }

        .callBack__body img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .callBack__phone,
        .callBack__whatsApp,
        .callBack__instagram,
        .callBack__mail {
            position: absolute;
            top: 0;
            left: 0;
            width: 30px;
            height: 30px;
            cursor: pointer;
            z-index: 0;
            margin: 10px;
            cursor: pointer;
            z-index: -1;
            transition: all .8s ease;
            display: block;
        }

        .callBack__instagram:hover,
        .callBack__phone:hover,
        .callBack__whatsApp:hover,
        .callBack__mail:hover {
            width: 35px;
            height: 35px;
        }

        .callBack__phone.active {
            transform: translateY(-70px)
        }

        .callBack__whatsApp.active {
            transform: translateY(-120px)
        }

        .callBack__mail.active {
            transform: translateY(-170px)
        }

        .callBack__instagram.active {
            transform: translateY(-220px)
        }


        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(.7);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="lk-page {{request()->path()}}-page">


<header>
    <div class="container">

        <div class="header-top flex flex-wrap between align-center">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('assets/images/logo.png') }}">
                </a>
            </div>


            @auth
                <div class="menu-btn_wrap menu-btn_wrap1">
                    <div class="pers-area">
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M3.42779 5.52686V8.26415H2.51445C1.53958 8.26415 0.689453 8.97259 0.689453 9.93706V17.5412C0.689453 18.5057 1.53958 19.2141 2.51445 19.2141H13.4645C14.4393 19.2141 15.2895 18.5057 15.2895 17.5412V9.93706C15.2895 8.97259 14.4393 8.26415 13.4645 8.26415H12.5528V5.52686C12.5528 3.00706 10.5101 0.964355 7.99029 0.964355C5.47049 0.964355 3.42779 3.00706 3.42779 5.52686ZM10.7278 5.52686V8.26415H5.25279V5.52686C5.25279 4.01498 6.47841 2.78936 7.99029 2.78936C9.50217 2.78936 10.7278 4.01498 10.7278 5.52686ZM2.51361 17.3893V10.0893H13.4636V17.3893H2.51361ZM8.90111 13.7391C8.90111 14.2431 8.49257 14.6516 7.98861 14.6516C7.48465 14.6516 7.07611 14.2431 7.07611 13.7391C7.07611 13.2352 7.48465 12.8266 7.98861 12.8266C8.49257 12.8266 8.90111 13.2352 8.90111 13.7391Z"
                                  fill="#DC1E52"/>
                        </svg>
                        <a>Личный кабинет</a>
                        <span
                            class="item-numbers">{{ App\Models\Notification::where('user_id',Auth::user()->id)->where('read',0)->count() }}</span>
                        <div class="dropdown-area">
                            <div class="account-date">
                                <p class="name-surname">{{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
                                <p class="account-email">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="drop-links">
                                <a href="{{ route('profile.index')}}">Мой профиль</a>
                                <a href="{{ route('profile.parcels') }}">Мои посылки</a>
                                <a href="{{ route('profile.addresses') }}">Мои адреса</a>
                                <a href="{{ route('profile.parcels.create') }}">Добавить посылку</a>
                                <a href="{{ route('profile.transactions') }}">Мои транзакции</a>
                                <a href="{{ route('profile.settings') }}">Настройки аккаунта</a>
                                <a href="{{ route('profile.notifications') }}">Мои уведомления
                                    ({{ App\Models\Notification::where('user_id',Auth::user()->id)->where('read',0)->count() }})</a>
                                <a style="display: none;" href="{{ route('profile.referal') }}">Реферальная программа</a>
                            </div>
                        </div>
                    </div>

                    <div class="cash hide">
                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.29665 4.78131C2.76724 4.78131 2.3364 4.35015 2.3364 3.82111C2.3364 3.28896 2.76432 2.8609 3.29952 2.8609H15.7416V0.942383H3.29952C1.70465 0.942383 0.417969 2.22952 0.417969 3.82106C0.417969 3.86688 0.419048 3.91247 0.417969 3.95775V15.3062C0.417969 16.8933 1.70457 18.1806 3.29422 18.1846L14.7947 18.2138C16.3853 18.2178 17.6758 16.934 17.6758 15.3444V4.78131H3.29665ZM15.7573 15.3444C15.7573 15.8714 15.3298 16.2967 14.7995 16.2953L3.29903 16.2662C2.76616 16.2649 2.33635 15.8348 2.33635 15.3062V6.53548C2.63671 6.64187 2.95991 6.69978 3.2966 6.69978H15.7573V15.3444Z"
                                fill="#DC1E52"/>
                            <path
                                d="M13.8258 10.5606H16.8017V8.64209H13.8258C12.2355 8.64209 10.9451 9.933 10.9451 11.5221C10.9451 13.1117 12.2378 14.4021 13.8259 14.4021H16.8017V12.4837H13.8259C13.2966 12.4837 12.8635 12.0514 12.8635 11.5221C12.8635 10.9924 13.2952 10.5606 13.8258 10.5606Z"
                                fill="#DC1E52"/>
                        </svg>
                        <span>{{ Auth::user()->balance }}$</span>

                        {{-- <div class="dropdown-cash">
                            <div class="score" style="border-bottom: 0">
                                <div class="balance-it">
                                    <p class="sc">Счет</p>
                                    <p class="balance">{{ Auth::user()->balance }}$</p>
                                </div>
                                <div class="topup">
                                    <a href="{{ route('profile.balance') }}">Пополнить</a>
                                </div>
                            </div>
                            {{-- <div class="bonus-block">
                                <div class="score">
                                    <div class="balance-it">
                                        <p class="sc">Бонус</p>
                                        <p class="balance">0.00$</p>
                                    </div>
                                    <div class="topup-bonus">
                                        <a href="#">Пополнить</a>
                                    </div>
                                </div>
                            </div>
                            <div class="invite-friend">
                                <p class="inv">Пригласить друга</p>
                                <p class="sub-inv">Приглашай друзей – получай боусы!</p>
                                <div class="invite">
                                    <a href="{{ route('profile.referal') }}">Пригласить друга</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                </div>
            @else
                <div class="menu-btn_wrap menu-btn_wrap2">
                    <a class="bt btn-orange btn-login" href="/login">
                        <svg width="18" height="23" viewBox="0 0 18 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.8635 9.57529H14.9745V6.46398C14.9745 3.18173 12.3077 0.514893 9.02543 0.514893C5.74318 0.514893 3.07634 3.18173 3.07634 6.46398V9.57529H2.1874C1.5036 9.57529 0.922363 10.1565 0.922363 10.8403V11.5925V20.3452V21.0974C0.922363 21.7812 1.5036 22.3624 2.1874 22.3624H9.02543H15.8635C16.5473 22.3624 17.1285 21.7812 17.1285 21.0974V20.3452V11.5925V10.8403C17.1285 10.1565 16.5473 9.57529 15.8635 9.57529ZM10.3589 18.6015H7.65783L8.13649 16.3108C7.69202 16.0372 7.38431 15.5244 7.38431 14.9431C7.38431 14.0542 8.1023 13.3362 8.99124 13.3362C9.88019 13.3362 10.5982 14.0542 10.5982 14.9431C10.5982 15.5244 10.2905 16.003 9.846 16.3108L10.3589 18.6015ZM9.02543 9.57529H5.19613V6.46398C5.19613 4.34419 6.90564 2.63468 9.02543 2.63468C11.1452 2.63468 12.8547 4.34419 12.8547 6.46398V9.57529H9.02543Z"
                                fill="white"/>
                        </svg>
                        Вход
                    </a>
                    <a class="bt orange-link btn-register" href="/register">Регистрация</a>
                </div>
            @endauth


            <a href="#menu" class="openMenu">
                <svg class="hamb hamb6" viewBox="0 0 100 100" width="50">
                    <path class="line top"
                          d="m 30,33 h 40 c 13.100415,0 14.380204,31.80258 6.899646,33.421777 -24.612039,5.327373 9.016154,-52.337577 -12.75751,-30.563913 l -28.284272,28.284272"></path>
                    <path class="line middle"
                          d="m 70,50 c 0,0 -32.213436,0 -40,0 -7.786564,0 -6.428571,-4.640244 -6.428571,-8.571429 0,-5.895471 6.073743,-11.783399 12.286435,-5.570707 6.212692,6.212692 28.284272,28.284272 28.284272,28.284272"></path>
                    <path class="line bottom"
                          d="m 69.575405,67.073826 h -40 c -13.100415,0 -14.380204,-31.80258 -6.899646,-33.421777 24.612039,-5.327373 -9.016154,52.337577 12.75751,30.563913 l 28.284272,-28.284272"></path>
                </svg>
            </a>
        </div>

        <x-mainNav></x-mainNav>

    </div>

</header>

<div class="menuclose"></div>


@yield('content')

<x-fixedBox></x-fixedBox>
<a id="button"></a>
<x-footer></x-footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
<script src="{{ asset('/js/slick.js') }}"></script>
<script src="{{ asset('/js/jquery.fancybox.min.js')}}"></script>
<script src="{{ asset('/js/script.js') }}"></script>
<script src="{{ asset('/js/dev.js') }}"></script>
<script>
    let btn = document.querySelector('.callBack__icon');
    let instagram = document.querySelector('.callBack__instagram');
    let phone = document.querySelector('.callBack__phone');
    let whatsApp = document.querySelector('.callBack__whatsApp');
    let mail = document.querySelector('.callBack__mail');

    btn.onclick = function () {
        instagram.classList.toggle('active')
        phone.classList.toggle('active')
        whatsApp.classList.toggle('active')
        mail.classList.toggle('active')
    }
</script>
@yield('script')
</body>
</html>
