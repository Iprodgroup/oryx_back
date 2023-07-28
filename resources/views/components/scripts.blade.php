
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
