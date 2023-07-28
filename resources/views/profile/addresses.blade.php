@extends('layouts.app',[
    'title'=>'Мои адреса',
])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">
        <div class="parcels-content">
            <!--<div class="parcels-menu">
                <div class="parcels-menublock">
                    <div class="transact-nav mb-50px">
                        <a class="transact-link active" href="#">США</a>
                        <a class="transact-link" href="{{ route('profile.addresses_eu') }}">Европа</a>
                    </div>
                </div>
            </div>-->

            <div class="content-adresses">

                <div class="country-wrap flex flex-wrap between">

                    <div>
                        <div class="title adress-count">
                          Ваш адрес в США
                        </div>
                        <p class="sub-adress">Введите этот адрес как адрес доставки при совершении онлайн покупок из магазинов США.</p>
                        @php
                            $addr = App\Models\Setting::where('id',6)->first();
                            $addr = explode('/', $addr->value);
                            for ($i=0; $i <= 7; $i++) {
                                $addr[$i] = isset($addr[$i])?$addr[$i]:'';
                            }
                        @endphp
                    </div>

                    <div class="parcels-inputs">
                        <a href="{{ route('profile.parcels.create') }}" class="bt btn-orange add-parcel">Добавить посылку</a>
                    </div>

                </div>

                <div class="count-flex flex flex-wrap between">
                    <div class="main-block-adress">
                        <div class="main-head">
                            <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M35.9518 25.832L21.8594 11.7411V5.49214C21.8594 4.50565 21.6405 3.51153 21.2088 2.58425L20.8881 1.97626C20.5096 1.15999 19.7176 0.653809 18.8193 0.653809C17.9209 0.653809 17.1289 1.15999 16.7672 1.94127L16.413 2.61767C15.998 3.51146 15.7791 4.50408 15.7791 5.49207V11.741L1.69129 25.829C0.973851 26.5464 0.578613 27.4995 0.578613 28.5149V30.2964C0.578613 30.5746 0.730595 30.83 0.973851 30.9622C1.21704 31.096 1.51501 31.0868 1.74908 30.9349L16.074 21.7552C16.2154 24.0551 16.4069 25.9749 16.641 28.3113L16.8827 30.7053L11.561 34.2212C11.3467 34.3641 11.219 34.6012 11.219 34.8566V36.3766C11.219 36.6061 11.3239 36.825 11.5032 36.9694C11.6841 37.1154 11.9197 37.1701 12.1431 37.1199L18.8192 35.6348L25.4953 37.1199C25.55 37.1321 25.6047 37.1382 25.6594 37.1382C25.8312 37.1382 25.9984 37.0804 26.1352 36.9709C26.3145 36.825 26.4194 36.6061 26.4194 36.3766V34.8566C26.4194 34.6012 26.2917 34.3626 26.0774 34.2227L20.7557 30.7114L20.9974 28.3097C21.2314 25.9764 21.423 24.0581 21.5643 21.7582L35.8893 30.9348C36.1249 31.0868 36.4213 31.0944 36.663 30.9621C36.9078 30.8299 37.0598 30.5745 37.0598 30.2964V28.5148C37.0599 27.4995 36.6662 26.5464 35.9518 25.832Z" fill="#E65A57"/>
                            </svg>
                            Доставка на склад США 5-10 раб. дней
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
                                <p class="adress-ex"><input type="text" disabled value="Ваша фамилия на английском"></p>
                            </div>

                        </div>
                        <div class="adresses-flex adresinput">
                            <div class="adresses-info">
                                <p class="adress-item">Address 1:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[0] }} {{ Auth::user()->address }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="181 EDGEMOOR RD"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop3" id="cop3" />
                                <label for="cop3" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex adresinput">
                            <div class="adresses-info">
                                <p class="adress-item">Address 2:</p>

                                @php

                                    $check = App\Models\Recipient::where('user_id', auth()->user()['id'])->exists();
                                    if($check == true){
                                        $orxId = auth()->user()->id_orx;
                                    } else {
                                        $orxId = '';
                                    }
                                @endphp
                                <p class="adress-ex"><input type="text" disabled value="{{
//                            auth()->user()->id_orx
                                $orxId
                            }}{{-- $addr[1] --}}"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop4" id="cop4" />
                                <label for="cop4" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex">
                            <div class="adresses-info">
                                <p class="adress-item">City:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[2] }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="WILMINGTON"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop5" id="cop5" />
                                <label for="cop5" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex">
                            <div class="adresses-info">
                                <p class="adress-item">State:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[3] }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="DE (Delaware)"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop6" id="cop6" />
                                <label for="cop6" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex">
                            <div class="adresses-info">
                                <p class="adress-item">Zip code:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[4] }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="19809-3170"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop7" id="cop7" />
                                <label for="cop7" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex">
                            <div class="adresses-info">
                                <p class="adress-item">Country:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[5] }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="USA (United States of America) "></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop8" id="cop8" />
                                <label for="cop8" class="label-svg">
                                     copy
                                </label>
                            </div>
                        </div>
                        <div class="adresses-flex">
                            <div class="adresses-info">
                                <p class="adress-item">Phone:</p>
{{--                                <p class="adress-ex"><input type="text" disabled value="{{ $addr[6] }}"></p>--}}
                                <p class="adress-ex"><input type="text" disabled value="+19176057707"></p>
                            </div>
                            <div class="copy">
                                <input type="checkbox" name="cop9" id="cop9" />
                                <label for="cop9" class="label-svg">
                                    copy
                                </label>
                            </div>
                        </div>

                        <div class="adresses-flex">
                            <div class="adress-under">
                                09:00 - 17:00 понедельник-пятница, по времени Делавэра
                            </div>
                        </div>

                        </div>

                    </div>

                    <div class="right-adresses">
                        <div class="vazhno">
                            <div class="vazhno-head">Важно знать</div>
                            <p>*Необходимо полностью заполнить ваши имя и фамилию (латиницей).</p>
                            <p>*Также убедитесь в корректности заполнения <strong>Address Line 2 &ndash; 2044389</strong> это уникальный номер (ID), который вы получаете при регистрации на сайте и видите в своем аккаунте. По нему мы узнаем, что это ваша посылка.</p>
                            <p>*Для быстрой регистрации посылки, пожалуйста введите трек-номер посылки.</p>
                            <p>*Вы можете получить свою посылку в течение &asymp;5-10 рабочих дней после ввоза посылки на наш международный склад.</p>
                        </div>
                        <div class="adresses-links">
                            <a class="bt btn-orange zapres-btn" href="/zapreshenye-tovary">Смотреть список запрещенных товаров</a>
                        </div>
                        <img src="/public/images/address-img.png" class="adresses-img">
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
