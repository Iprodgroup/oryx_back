@extends('layouts.app',[
    'title'=>'Мои адреса',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Мои адреса'
    ],
])

@section('content')
    <x-profileNav></x-profileNav>

    <div class="container">
        <div class="parcels-content">
            <div class="parcels-menu">
                <div class="parcels-menublock">
                    <div class="transact-nav mb-50px">
                        <a class="transact-link" href="{{ route('profile.addresses') }}">США</a>
                        <a class="transact-link active" href="#">Европа</a>
                    </div>

                </div>
            </div>

            <div class="content-adresses">

                <div class="country-wrap flex flex-wrap between">

                    <div>
                        <div class="title adress-count">
                            Ваш адрес в Европе
                        </div>
                        <p class="sub-adress">Введите этот адрес как адрес доставки при совершении онлайн покупок из
                            магазинов Европы.</p>
                        @php
                            $addr = App\Models\Setting::where('id',15)->first();
                            $addr = explode('/', $addr->value);
                            for ($i=0; $i <= 7; $i++) {
                                $addr[$i] = isset($addr[$i])?$addr[$i]:'';
                            }
                        @endphp
                    </div>


                    <div class="parcels-inputs">
                        <a href="{{ route('profile.parcels.create') }}" class="bt btn-orange add-parcel">Добавить
                            посылку</a>
                    </div>
                </div>


                <div class="count-flex flex flex-wrap between">
                    <div class="main-block-adress">
                        <div class="main-head">
                            <svg width="38" height="37" viewBox="0 0 38 37" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M36.3043 25.4325L22.2119 11.3416V5.09273C22.2119 4.10624 21.993 3.11212 21.5613 2.18484L21.2406 1.57684C20.8621 0.760572 20.0702 0.254395 19.1718 0.254395C18.2735 0.254395 17.4815 0.760573 17.1197 1.54186L16.7655 2.21826C16.3506 3.11205 16.1317 4.10467 16.1317 5.09266V11.3416L2.04383 25.4296C1.32639 26.147 0.931152 27.1001 0.931152 28.1155V29.897C0.931152 30.1752 1.08313 30.4306 1.32639 30.5628C1.56958 30.6965 1.86755 30.6874 2.10162 30.5354L16.4266 21.3558C16.5679 23.6556 16.7595 25.5755 16.9935 27.9118L17.2352 30.3059L11.9135 33.8218C11.6992 33.9647 11.5715 34.2018 11.5715 34.4572V35.9772C11.5715 36.2067 11.6764 36.4256 11.8557 36.57C12.0366 36.716 12.2722 36.7707 12.4957 36.7205L19.1717 35.2354L25.8478 36.7205C25.9025 36.7327 25.9573 36.7388 26.012 36.7388C26.1838 36.7388 26.3509 36.681 26.4877 36.5715C26.6671 36.4256 26.772 36.2067 26.772 35.9772V34.4572C26.772 34.2018 26.6443 33.9632 26.4299 33.8233L21.1082 30.312L21.3499 27.9103C21.584 25.577 21.7755 23.6587 21.9169 21.3588L36.2418 30.5354C36.4775 30.6873 36.7739 30.695 37.0156 30.5627C37.2603 30.4305 37.4123 30.1751 37.4123 29.8969V28.1154C37.4125 27.1001 37.0188 26.147 36.3043 25.4325Z"
                                      fill="#4459C4"/>
                            </svg>
                            Доставка на склад Европы 5-10 раб. дней
                        </div>


                        <div class="adresses-flex_wrap flex flex-wrap between">

                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">Name:</p>
                                    <p class="adress-ex"><input type="text" disabled value="Ваше имя на английском"></p>
                                </div>

                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">Surname:</p>
                                    <p class="adress-ex"><input type="text" disabled value="Ваша фамилия на английском">
                                    </p>
                                </div>

                            </div>
                            <div class="adresses-flex adresinput">
                                <div class="adresses-info">
                                    <p class="adress-item">Address 1:</p>
                                    <p class="adress-ex"><input type="text" disabled
                                                                value="{{ $addr[0] }} {{ Auth::user()->address }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop3" id="cop3"/>
                                    <label for="cop3" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex adresinput">
                                <div class="adresses-info">
                                    <p class="adress-item">Address 2:</p>
                                    <p class="adress-ex"><input type="text" disabled
                                                                value="{{ auth()->user()->id }}{{-- $addr[1] --}}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop4" id="cop4"/>
                                    <label for="cop4" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">City:</p>
                                    <p class="adress-ex"><input type="text" disabled value="{{ $addr[2] }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop5" id="cop5"/>
                                    <label for="cop5" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">State:</p>
                                    <p class="adress-ex"><input type="text" disabled value="{{ $addr[3] }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop6" id="cop6"/>
                                    <label for="cop6" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">Zip code:</p>
                                    <p class="adress-ex"><input type="text" disabled value="{{ $addr[4] }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop7" id="cop7"/>
                                    <label for="cop7" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">Country:</p>
                                    <p class="adress-ex"><input type="text" disabled value="{{ $addr[5] }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop8" id="cop8"/>
                                    <label for="cop8" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>
                            <div class="adresses-flex">
                                <div class="adresses-info">
                                    <p class="adress-item">Phone:</p>
                                    <p class="adress-ex"><input type="text" disabled value="{{ $addr[6] }}"></p>
                                </div>
                                <div class="copy">
                                    <input type="checkbox" name="cop9" id="cop9"/>
                                    <label for="cop9" class="label-svg">
                                        copy
                                    </label>
                                </div>
                            </div>

                            <div class="adresses-flex">
                                <div class="adress-under">
                                    9:00 -18:00 понедельник - пятница. Ганновер, Германия
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="right-adresses">
                        <div class="vazhno">
                            <div class="vazhno-head">Важно знать</div>
                            <p>*Необходимо полностью заполнить ваши имя и фамилию (латиницей).</p>
                            <p>*Также убедитесь в корректности заполнения <strong>Address Line 2 &ndash;
                                    2044389</strong> это уникальный номер (ID), который вы получаете при регистрации на
                                сайте и видите в своем аккаунте. По нему мы узнаем, что это ваша посылка.</p>
                            <p>*Для быстрой регистрации посылки, пожалуйста введите трек-номер посылки.</p>
                            <p>*Вы можете получить свою посылку в течение &asymp;5-10 рабочих дней после ввоза посылки
                                на наш международный склад.</p>
                        </div>
                        <div class="adresses-links">
                            <a class="bt btn-orange zapres-btn" href="/zapreshenye-tovary">Смотреть список запрещенных
                                товаров</a>
                        </div>
                        <img src="/public/images/address-img.png" class="adresses-img">
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
