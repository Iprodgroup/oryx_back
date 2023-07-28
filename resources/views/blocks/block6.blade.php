<div class="faq-wrap mb-100px  wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.1s"
     style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.1s; animation-name: fadeInUp;">

    <div class="container">

        <div class="title faq-title">
            Популярные вопросы
        </div>

        <div class="faq">


            @foreach($questions as  $qusetion)
                <div class="faq-item">
                    <div class="faq-head">
                        {{ $qusetion->question }}<span></span>
                    </div>
                    <div class="faq-content">
                        {!! $qusetion->response !!}
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</div>
