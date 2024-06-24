@extends('layouts.app',[
    'title'=>'Регистрация',
    'breadcrumbs'=>[
        route('register')=>'Регистрация'
    ],
])

@section('content')


<div class="loginwrap flex flex-wrap">

    <div class="loginbox">
        <div class="head login-head">
            РЕГИСТРАЦИЯ НА САЙТЕ
        </div>
        <div class="login-text">
           Пожалуйства, заполните все поля заявки
        </div>

        {{-- @if ($errors->any())
                <div class="alert alert-danger obshiy padding polzovtel">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
         <form id="registeration" method="POST" action="{{ route('register') }}">
                @csrf

            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Электронная почта" class="unstyled @error('email') is-invalid @enderror" />
             <span class="alert-danger" role="alert">
                 <strong>
                     @foreach ($errors->get('email') as $message)
                         {{ $message}}
                     @endforeach
                 </strong>
             </span>

            <input id="password" type="password" name="password" required placeholder="Пароль" class="unstyled @error('password') is-invalid @enderror" />
            @error('password')<span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>@enderror

            <input id="password-check" type="password" name="password_confirmation" required placeholder="Подтвердите пароль" class="unstyled" />

            <input type="tel" name="phone" id="phone1" value="" placeholder="+7 (___) ___-__-__" class="unstyled" />

             <strong id="password-len" style="display: none">
                 пароль должен быт не меньше 8 символ
                 <br>
             </strong>

            <button id="register" type="submit" class="bt btn-orange loginform-btn">Зарегистрироваться</button>

            <div class="confirm">
                <input type="checkbox" id="confirm" class="check-confirm" required />
                <label for="confirm" class="label-confirm">Я принимаю <a target="_blank" href="/politika-konfidentsialnosti">Условия и Положения</a></label>
            </div>

        </form>

    </div>

    <div class="loginsocial">
        @include('partials.log-in-with')
    </div>

</div>

@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var pass1 = document.querySelector('#password'),
                pass2 = document.querySelector('#password-check'),
                button = document.querySelector('#register');

            pass1.addEventListener('input', function () {
                this.value != pass2.value || this.value.length < 8 ? setDisabe(pass2, this.value) : unsetDisabe();
            });

            pass2.addEventListener('input', function () {
                this.value != pass1.value || this.value.length < 8 ? setDisabe(pass1, this.value) : unsetDisabe();
            });

            function setDisabe(pass, value) {
                button.disabled = true;
                pass.style.border = '1px solid red';

                if(value.length < 8) {
                    document.getElementById('password-len').style.display = 'block'
                } else {
                    document.getElementById('password-len').style.display = 'none'
                }
            }

            function unsetDisabe() {
                button.disabled = false;
                pass1.style.border = 'none';
                pass2.style.border = 'none';
            }
        })

        var element = document.getElementById('phone1');
        var maskOptions = {
            mask: '+{7}(000)000-00-00',
            lazy: false
        }
        var mask = new IMask(element, maskOptions);
    </script>
@endsection
