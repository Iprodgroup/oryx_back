<link href="/?format=feed&type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0">
<link href="/?format=feed&type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0">

<link rel="stylesheet" href=" {{ asset('assets/css/bootstrap.min.css') }} ">
<link rel="stylesheet" href=" {{ asset('assets/css/jquery.fancybox.min.css') }} " type="text/css">
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="{{ asset('assets/css/css2.css') }} " rel="stylesheet">

<link rel="stylesheet" href=" {{ asset('assets/css/animate.css') }} " type="text/css">
<link rel="stylesheet" href=" {{ asset('assets/css/slick.css') }} " type="text/css">
<link rel="stylesheet" href=" {{ asset('assets/css/slick-theme.css') }} " type="text/css">

<link rel="stylesheet" href=" {{ asset('assets/css/style.css') }} " type="text/css">
<link rel="stylesheet" href=" {{ asset('assets/css/media.css') }} " type="text/css">

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

    .callBack__instagram,
    .callBack__phone,
    .callBack__whatsApp,
    .callBack__mail{
        position: absolute;
        top: 0;
        left: 0;
        width: 30px;
        height: 30px;
        cursor: pointer;
        margin: 10px;
        z-index: -1;
        transition: all .8s ease;
        display: block;
    }

    .callBack__instagram:hover,
    .callBack__phone:hover,
    .callBack__whatsApp:hover,
    .callBack__mail:hover
    {
        width: 35px;
        height: 35px;
    }

    .callBack__phone.active {
        transform: translateY(-70px)
    }

    .callBack__mail.active {
        transform: translateY(-120px)
    }

    .callBack__whatsApp.active {
        transform: translateY(-170px)
    }

    .callBack__instagram.active {
        transform: translateY(-220px)
    }

    .callBack__phone, .callBack__whatsApp, .callBack__mail {
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

    #scroll {
        display: inline-block;
        background-color: #FF9800;
        width: 50px;
        height: 50px;
        text-align: center;
        border-radius: 4px;
        position: fixed;
        bottom: 30px;
        right: 30px;
        transition: background-color .3s,
        opacity .5s, visibility .5s;
        opacity: 0;
        visibility: hidden;
        z-index: 1000;
    }
    #scroll:hover {
        cursor: pointer;
        background-color: #333;
    }
    #scroll:active {
        background-color: #555;
    }
    #scroll.show {
        opacity: 1;
        visibility: visible;
    }
</style>

{{--banner--}}
<style>

    .fixed .attention-bar {
        opacity: 0;
    }
    .attention-bar {
        background-color:#e87324;
        width:100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
    }
    .attention-bar>.container {
        height:100%
    }
    .attention-bar__text--out {
        min-height:40px;
        height:100%;
        padding:5px 0;
        text-align:center
    }
    .attention-bar__text {
        margin-right:50px;
        display:inline-block;
        vertical-align:middle;
        vertical-align:-webkit-baseline-middle;
        vertical-align:-moz-middle-with-baseline
    }
    .attention-bar .btn--close {
        right:0;
        top:7px
    }
    .attention-bar a,
    .attention-bar__text {
        color:#fff
    }
    .attention-bar a {
        text-decoration:underline
    }
</style>
<link rel="shortcut icon" href="/images/site/favicon.png" type="image/png">

{{ $slot }}

<script src=" {{ asset('assets/js/jquery.min_002.js') }} " type="text/javascript"></script>

