<a id="scroll" class="" style="padding: 10px; background-color: #e65a57">
    <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 0 448 512">
        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
        <style>svg {
                fill: #ffffff
            }</style>
        <path
            d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z"/>
    </svg>
</a>
<script src=" {{ asset('assets/js/slick.js') }} " type="text/javascript"></script>

<script src=" {{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src=" {{ asset('assets/js/slick.js') }} "></script>
<script src=" {{ asset('assets/js/maskedinput.js') }} "></script>
<script src=" {{ asset('assets/js/jquery.fancybox.min.js') }} "></script>
<script src=" {{ asset('assets/js/parallax.js') }} "></script>
<script src=" {{ asset('assets/js/wow.js') }} "></script>
<script> if (window.innerWidth > 768) {new WOW().init();}</script>
<script src=" {{ asset('assets/js/script.js') }} "></script>
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

    var btnscrool = $('#scroll');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btnscrool.addClass('show');
        } else {
            btnscrool.removeClass('show');
        }
    });

    btnscrool.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });
</script>
{{ $slot }}
