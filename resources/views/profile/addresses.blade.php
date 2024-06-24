@extends('layouts.app',['title'=>'Мои адреса',])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">
        <div class="parcels-content">

            <div class="content-adresses">

                <div class="country-wrap flex flex-wrap between">

                    <div>
                        <div class="title adress-count">
                          Ваш адрес
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
                            Ваши персональные адреса
                        </div>

                        <div class="tabtab">

                            @php
                                $addresses = \App\Models\Address::get();
                                $tabs = \App\Models\Setting::whereIn('id', $addresses->pluck('tab'))->get();
                                $active = $tabs->first();
                            @endphp

                            @foreach($tabs as $key => $tab)
                                <button class="tablinks {{ !$loop->first ?: 'active' }}" onclick="openCity(event, '{{ $tab->name }}')">{{ $tab->name }}</button>
                            @endforeach

                        </div>

                        @foreach($tabs as $key => $tab)
                            <div id="{{ $tab->name }}" class="tabcontent">
                                <div class="faq">

                                    @foreach($addresses->where('tab', $tab->id) as $address)
                                        <div class="faq-item">
                                            <div class="faq-head"> {{ $address->title }} <span></span></div>
                                            <div class="faq-content">
                                                <div class="adresses-flex_wrap flex flex-wrap between">

                                                    <x-address :title="'Name:'" :value="'Ваше имя на английском'"/>
                                                    <x-address :title="'Surname:'" :value="'Ваша фамилия на английском'"/>
                                                    <x-address :title="'Address 1:'" :value="$address->address1" :class="'adresinput'" :copy="true"/> @php
                                                        $check = App\Models\Recipient::where('user_id', auth()->user()['id'])->exists();
                                                        if($check == true){$orxId = auth()->user()->id_orx;}
                                                        else {$orxId = '';}
                                                    @endphp
                                                    <x-address :title="'Address 2:'" :value="$orxId" :class="'adresinput'" :copy="true"/>
                                                    <x-address :title="'City:'" :value="$address->city" :copy="true"/>
                                                    <x-address :title="'State:'" :value="$address->state" :copy="true"/>
                                                    <x-address :title="'Zip code:'" :value="$address->zip_code" :copy="true"/>
                                                    <x-address :title="'Country:'" :value="$address->country" :copy="true"/>
                                                    <x-address :title="'Phone:'" :value="$address->phone" :copy="true"/>

                                                    <div class="adresses-flex">
                                                        <div class="adress-under">{{ $address->address_under }}</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

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
                        <img src="/storage/images/address-img.png" class="adresses-img">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    <style>
        .tabtab {
            width: 100%;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            height: 52px;
        }

        /* Style the buttons that are used to open the tab content */
        .tabtab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tabtab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tabtab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
        }

        .tabcontent .active{
            display: block;
        }

        .tabcontent {
            animation: fadeEffect 1s; /* Fading effect takes 1 second */
        }

        /* Go from zero to full opacity */
        @keyframes fadeEffect {
            from {opacity: 0;}
            to {opacity: 1;}
        }


        /* Links inside the navbar */
        .navbar a {
            float: left;
            font-size: 16px;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* The dropdown container */
        .dropdown {
            float: left;
        }

        /* Dropdown button */
        .dropdown .dropbtn {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 210px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            top: 50px;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        /* Add a grey background color to dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
@endsection

@section('script')
    <script>
        let copy = document.querySelector('.content-adresses');

        console.log(copy)

        copy.addEventListener('click', function(event) {
            let btn = event.target.closest('.copy');

            let all = document.querySelectorAll('.copy')
            for (let item in all) {all[item].textContent = 'copy'}
            if (btn) {
                btn.textContent = 'copied'
                navigator.clipboard.writeText(btn.parentElement.childNodes[3].childNodes[0].value)
            }
        });

        function openCity(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById('{{ $active->name }}').style.display = "block";
    </script>
@endsection
