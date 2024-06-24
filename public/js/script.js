$(document).ready(function (){


    window.onscroll = function() {scrollFunction()};
    
    function scrollFunction() {
          if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
            document.querySelector("header").classList.add("fixed"); 
          } else {
            document.querySelector("header").classList.remove("fixed"); 
          }
    }
     
     
   /* $(".pers-area > a").on("click", function(){
        $(this).parent().find(".dropdown-area").slideToggle();;
        return false;
    }) */
    
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
    
    $(".email-verif_close").on("click", function(){
        $(".email-verif").addClass("hide");
        $(".email-verif_fon").addClass("hide");
    })
    
    $('.main-block-adress .copy').click(function(){
        var $input = $(this).prev().find('input');
    		$input.prop('disabled',false);
        $input.select();
    		$input.prop('disabled',true);
        document.execCommand("copy");
      });
     



});