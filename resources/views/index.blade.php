@extends('layouts.app')

@section('content')
    <div class="mainblock">
        <div class="slicker" id="slick1">
            <div class="slickitem">
                <img src="/images/Group_4135.svg">
            </div>
            <div class="slickitem">
                <img src="/images/Group_4135.svg">
            </div>
            <div class="slickitem">
                <img src="/images/Group_4135.svg">
            </div>
        </div>
        <div class="container">
            <div class="siteinfo">
                <h1 class="bigtext">Безопасная доставка</h1>
                <p class="slog">Покупай онлайн в США и в Англии и получай в Казахстане</p>
                <a href="/payment.php" class="payment-link">Расчет стоимости</a>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="rabotaet">
            <div class="centerhead">
                Как это работает?
            </div>
            <p class="zarubezh">ПОКУПАЙ ЗАРУБЕЖОМ – ПОЛУЧАЙ В КАЗАХСТАНЕ</p>
            <div class="il-flex">
                <div class="il">
                    <div class="ilblock">
                        <img src="/images/il1.jpg">
                        <div class="ilnumber">1</div>
                    </div>
                    <div class="ilname">Регистрируйся</div>
                    <p class="iltext">Зарегистрируйтесь и получите персональный адрес в США</p>
                </div>
                <div class="il">
                    <div class="ilblock">
                        <img src="/images/il2.jpg">
                        <div class="ilnumber">2</div>
                    </div>
                    <div class="ilname">Покупай</div>
                    <p class="iltext">Покупайте онлайн в США и оформляйте доставку на ваш персональный адрес</p>
                </div>
                <div class="il">
                    <div class="ilblock">
                        <img src="/images/il3.jpg">
                        <div class="ilnumber">3</div>
                    </div>
                    <div class="ilname">Получай</div>
                    <p class="iltext">Получите свою посылку в течение 5-10 рабочих дней</p>
                </div>
            </div>
            <div class="centerbuttons">
                <a href="#" class="takeadress">Получить адрес</a>
                <div class="or">
                    <p>Или используйте наш сервис</p>
                    <a href="/buyinstead.php">"Купи вместо меня"</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="rabotaet">
            <div class="centerhead">
                Чаще всего заказывают в США
            </div>
            <p class="zarubezh">САМЫЕ ПОПУЛЯРНЫЕ ТОВАРЫ СРЕДИ НАШИХ КЛИЕНТОВ</p>
            <div class="gadjets responsive">
                <div class="jet-item">
                    <a href="#"><img src="/images/airpods.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/macbook.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/applewatch.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/galaxy.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/airpods.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/macbook.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/applewatch.jpg"></a>
                </div>
                <div class="jet-item">
                    <a href="#"><img src="/images/galaxy.jpg"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="shop-links">
            <a href="#"><img src="/images/walmart.jpg"></a>
            <a href="#"><img src="/images/zappos.jpg"></a>
            <a href="#"><img src="/images/ebay.jpg"></a>
            <a href="#"><img src="/images/apple.jpg"></a>
            <a href="#"><img src="/images/bestbuy.jpg"></a>
            <a href="#"><img src="/images/amazon.jpg"></a>
        </div>
    </div>

    <div class="whywork">
        <img src="/images/ban2.svg">
        <div class="container">
            <div class="wesite">
                <div class="wehead">
                    Как работает наш сайт?
                </div>
                <div class="wetext">
                    Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры текст. Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта.
                </div>
                <a class="movie-button" href="#">Смотреть ролик</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="whywe">
            <p class="whywe-head">Почему мы?</p>
            <p class="whywe-title">С нами вы экономите время и деньги</p>
            <div class="whywe-flex">
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
                <div class="whywe-item">
                    <svg width="59" height="52" viewBox="0 0 59 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.4428 0.185059H7.55716C7.10043 0.185059 6.66242 0.366491 6.33947 0.689442C6.01652 1.01239 5.83508 1.45041 5.83508 1.90713V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M45.4428 0.185059H43.7207V26.8772C43.7207 28.7041 42.995 30.4562 41.7032 31.748C40.4114 33.0398 38.6593 33.7655 36.8324 33.7655H5.83508V41.5148H47.1649V1.90713C47.1649 1.45041 46.9834 1.01239 46.6605 0.689442C46.3375 0.366491 45.8995 0.185059 45.4428 0.185059Z" fill="#4459C4"/>
                        <path d="M26.5 15.6837L31.6662 19.1279V0.185059H21.3337V19.1279L26.5 15.6837Z" fill="#FE5885"/>
                        <circle cx="44.19" cy="37.8355" r="13.9" fill="#FE5885"/>
                        <path d="M38.5933 36.5075L44.4622 42.3761L50.331 32.8008" stroke="white" stroke-width="3"/>
                    </svg>
                    <p>Это текст о компании. Он необходим для дальнейшего продвижения </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="reviews">
            <p class="whywe-head">Почему мы?</p>
            <p class="whywe-title">С нами вы экономите время и деньги</p>
            <div class="reviews-carouse">
                <div class="rev-item">
                    <div class="rev-block">
                        <div class="rev-author">
                            <img src="/images/author.jpg">
                            <div class="author">
                                <p class="author-name">Андрей Иванов</p>
                                <p class="author-city">Almaty</p>
                            </div>
                        </div>
                        <div class="rev-text">
                            Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры текст.
                        </div>
                    </div>
                </div>
                <div class="rev-item">
                    <div class="rev-block">
                        <div class="rev-author">
                            <img src="/images/author.jpg">
                            <div class="author">
                                <p class="author-name">Андрей Иванов</p>
                                <p class="author-city">Almaty</p>
                            </div>
                        </div>
                        <div class="rev-text">
                            Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры текст.
                        </div>
                    </div>
                </div>
                <div class="rev-item">
                    <div class="rev-block">
                        <div class="rev-author">
                            <img src="/images/author.jpg">
                            <div class="author">
                                <p class="author-name">Андрей Иванов</p>
                                <p class="author-city">Almaty</p>
                            </div>
                        </div>
                        <div class="rev-text">
                            Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры текст.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="whywork">
        <img src="/images/ban3.svg">
        <div class="container">
            <div class="wesite">
                <div class="wehead">
                    Рассчет стоимости доставки
                </div>
                <div class="stoimo">
                    Здесь будет мини-описание. Это текст о компании для продвижения сайта.
                </div>
                <a class="stoimost" href="/payment.php">Расчет стоимости</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="under-text">
            <p class="under-head">Здесь будет заголовок</p>
            <p class="text-under">Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры составят правильный текст. Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры составят правильный текст. Это текст о компании. Он необходим для дальнейшего продвижения Вашего сайта. Вам будет необходимо предоставить исходные данные, по которым наши копирайтеры составят правильный текст.</p>
        </div>
    </div>
@endsection