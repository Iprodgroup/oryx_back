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
         <form method="POST" action="{{ route('register') }}">
                @csrf 
                        
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Электронная почта" class="unstyled @error('email') is-invalid @enderror" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    
            <input type="password" name="password" required placeholder="Пароль" class="unstyled @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    
            <input type="password" name="password_confirmation" required placeholder="Подтвердите пароль" class="unstyled" />

            <input type="tel" name="phone" id="phone1" value="" placeholder="+7 (___) ___-__-__" class="unstyled" />
     
            <button type="submit" class="bt btn-orange loginform-btn">Зарегистрироваться</button>
            
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
