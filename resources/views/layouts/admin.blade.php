<!DOCTYPE html>
<html lang="ru">
    <head>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(94520712, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/94520712" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <link rel="icon" type="image/ico" href="{{ asset('admin/images/favicon.png') }}">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin/css/style.css?v=0.1') }}">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('admin/css/media.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    </head>
    <body>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-325N7WYDLE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-325N7WYDLE');
    </script>

    @if (Auth::check())
            @if (View::hasSection('header'))
                <div class="header-wrap">
                    @yield('header')

                    @include('admin.partials.top')
                </div>
            @else
                <div class="header-wrap">
                    <div class="header">
                        <a href="/" class="logo"><img src="{{ asset('admin/images/logoadmin.png') }}"></a>
                        <div class="cms">CMS</div>
                    </div>
                    @include('admin.partials.top')
                </div>
            @endif

            @include('admin.partials.left')


            @yield('content')
            <script src="{{ asset('admin/js/dev.js') }}"></script>
        @else
            @yield('content')
        @endif
    </body>
</html>
