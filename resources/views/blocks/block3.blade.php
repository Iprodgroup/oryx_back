<div class="container">

    <div class="title-wrap">
        <div class="title tovar-title">
            Примеры товаров из США
        </div>
        <div class="subtitle">
            Какие товары чаще всего заказывают в США
        </div>
    </div>

    <!---<div class="products flex flex-wrap between mb-70px">

      <div class="product wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s">

        <div class="product-name">
          Обувь
        </div>
        <div class="product-dost">
          доставка от
        </div>
        <div class="product-price">
          7.15$
        </div>
        <div class="product-img">
          <img src="/images/site/prod1.png">
        </div>

      </div>


      <div class="product wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.8s">

        <div class="product-name">
          Iphone
        </div>
        <div class="product-dost">
          доставка от
        </div>
        <div class="product-price">
          7.15$
        </div>
        <div class="product-img">
          <img src="/images/site/prod2.png">
        </div>

      </div>

      <div class="product wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1.1s">

        <div class="product-name">
          Одежда
        </div>
        <div class="product-dost">
          доставка от
        </div>
        <div class="product-price">
          7.15$
        </div>
        <div class="product-img">
          <img src="/images/site/prod3.png">
        </div>

      </div>

      <div class="product  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1.4s">

        <div class="product-name">
          Игрушки
        </div>
        <div class="product-dost">
          доставка от
        </div>
        <div class="product-price">
          7.15$
        </div>
        <div class="product-img">
          <img src="/images/site/prod4.png">
        </div>

      </div>


    </div>--->


    <div class="products col-md-12 flex flex-wrap  mb-70px">

        @foreach($products as $product)
            <div class="product col-md-6 col-lg-4 col-xl-3 wow fadeInLeft flex flex-column justify-content-between" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.5s; animation-name: fadeInLeft;">
                <div class="product-name">{{ $product->title }}</div>
                <div class="product-img"><img style="margin-top: 20px; margin-bottom: 50px; max-height: 200px;" src="assets/images/{{ $product->img }} "></div>
            </div>
        @endforeach

    </div>


</div>

<div class="calc-wrap mb-100px">

    <div class="container">

        <div class="calc flex flex-wrap">

            <div class="calc-item  wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.1s"
                 style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.1s; animation-name: fadeInLeft;">

                <div class="title calc-title">
                    Калькулятор
                    стоимости доставки
                </div>

                <form id="calcForm">
                    <div class="form-flex flex flex-wrap align-center">
                        <select class="selectcity calcinput">
                            <option value="0" disabled="disabled" selected="selected">Выбрать страну
                            </option>


                            <option value="13">США</option>
                            <option value="13">Европа</option>


                        </select>
                        <input type="text" class="ves calcinput" placeholder="Вес">
                        <div class="calcitog">
                            Итог: <span></span> $
                        </div>
                    </div>
                </form>

                <div class="calc-info flex flex-wrap align-center">
                    <div>
                        Срок доставки От 7 до 14 дней
                    </div>
                </div>

                <div class="calc-text">
                    * Стоимость доставки – 13 долларов за килограмм. Чтобы вы не
                    переплачивали, мы округляем расчет веса до 100 грамм. В списке можно
                    выбрать популярные товары и узнать примерную стоимость их доставки, а на
                    калькуляторе рассчитать точно по весу.
                </div>


            </div>

            <div class="calc-img  wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1.5s"
                 style="visibility: visible; animation-duration: 1.5s; animation-delay: 1.5s; animation-name: fadeInRight;">

                <div id="scene2" data-friction-x="0.1" data-friction-y="0.1" data-scalar-x="25"
                     data-scalar-y="15"
                     style="transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; position: relative; pointer-events: none;">
                    <div data-depth="0.10"
                         style="transform: translate3d(-0.4px, -1.7px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;">
                        <img src=" {{ asset('assets/images/calc.png') }} ">
                    </div>
                </div>
            </div>


        </div>

    </div>


</div>


<script>
    $(function () {

        $("select.selectcity.calcinput").on("change", function () {
            var weight = Math.ceil(parseFloat($('input.ves.calcinput').val().replace(/,/, '.')) * 10) / 10;
            calc($("select.selectcity.calcinput").val(), weight)
        })


        $('input.ves.calcinput').keyup(function () {
            var weight = Math.ceil(parseFloat($('input.ves.calcinput').val().replace(/,/, '.')) * 10) / 10;
            calc($("select.selectcity.calcinput").val(), weight);
        });

        function calc(country, weight) {


            //var weight = Math.ceil(parseFloat($('[name=weight]').val())*10)/10;

            //var weight = Math.ceil(parseFloat($('input.ves.calcinput').val().replace(/,/, '.'))*10)/10;

            if (!weight)
                weight = 0;
            $('.calcitog span').html(weight * country);
        }
    });
</script>
