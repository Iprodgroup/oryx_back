$(document).ready(function (){


    window.onscroll = function() {scrollFunction()};

    // $(".pers-area > a").on("click", function(){
    //     $(this).parent().find(".dropdown-area").slideToggle();;
    //     return false;
    // })

    function scrollFunction() {
        if(window.innerWidth < 768) {
            if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {

                let top = document.documentElement.scrollTop;

                document.querySelector("header").classList.add("fixed");
                if(top < 350) {
                    $("img.sliderbox").css('top', top*1.3+"px");
                }
            } else {
                document.querySelector("header").classList.remove("fixed");
                $("img.sliderbox").css('top', '15%');
            }
        } else {

            if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
                let top = document.documentElement.scrollTop;

                document.querySelector("header").classList.add("fixed");

                if(top < 700) {
                    $("img.sliderbox").css('top', top+"px");
                }

            } else {
                document.querySelector("header").classList.remove("fixed");
                $("img.sliderbox").css('top', '7%');
            }

        }

    }


    if($("#scene").length){

        var scene = document.getElementById('scene');
        var parallax = new Parallax(scene);

    }

    if($("#scene2").length){

        var scene2 = document.getElementById('scene2');
        var parallax2 = new Parallax(scene2);

    }




    jQuery("#formAddress").submit(function () {
	  var formAddress = jQuery('#formAddress');
	  jQuery.ajax({
		type: "POST"
		, url: "/templates/jtheme/postAddress.php"
		, data: formAddress.serialize()
		, success: function (data) {
		  jQuery('#formAddress .formsuccess').html(data);
		  jQuery(this).find("input").val("");
		  jQuery(formAddress).trigger("reset");
		  jQuery(formAddress).addClass("active");
		}
		, error: function (jqXHR, text, error) {
		  jQuery(formAddress).html(error);
		}
	  });
	  return false;
	});


    $(".maskphone").mask("+7 (999) 999-9999");



    $("a.openMenu").on("click", function(){
        $(this).toggleClass("active");
        $("nav.mainnav").toggleClass("active");
        $(".menuclose").toggleClass("active");
        return false;
    })
    $(".menuclose").on("click", function(){
        $(this).toggleClass("active");
        $("nav.mainnav").toggleClass("active");
        $("a.openMenu").toggleClass("active");
    })

    $(".fixed-open").on("click", function(){
        $(this).slideToggle();
        $(".fixedwrap").slideToggle();
    })
    $(".fixed-close").on("click", function(){
        $(".fixed-open").slideToggle();
        $(".fixedwrap").slideToggle();
    })


    $('.scroll-down').on( 'click', function(){
        var el = $(this);
        var dest = el.attr('href'); // получаем направление
        if(dest !== undefined && dest !== '') { // проверяем существование
            $('html,body').animate({
                scrollTop: $(dest).offset().top // прокручиваем страницу к требуемому элементу
            }, 700 // скорость прокрутки
            );
        }
        return false;
    });



    $(".aboutarrow-prev").on("click", function(){
        $(".aboutslider-arrow .slick-prev").trigger("click");
    })
    $(".aboutarrow-next").on("click", function(){
        $(".aboutslider-arrow .slick-next").trigger("click");
    })



	$('.review').not('.slick-initialized').slick({
        slidesToShow: 2,
        swipeToSlide: true,
        //autoplay: true,
        speed: 800,
        autoplaySpeed: 3000,
        dots: false,
        arrows: false,
        responsive: [
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 1,
                dots: true
              }
            },{
              breakpoint: 1000,
              settings: {
                slidesToShow: 1,
                dots: true
              }
            },
          ]
    });

    $(".faq-head").on("click", function(){
        $(this).parents(".faq-item").find(".faq-content").slideToggle();
        $(this).toggleClass("active");
    })



});
