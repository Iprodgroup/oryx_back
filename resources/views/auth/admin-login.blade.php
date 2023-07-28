@extends('layouts.admin')

@section('content')
    <div class="auth">
        <img src="/admin/images/authicon.svg">
        <p>Авторизация</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="inputs">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="in-auth @error('email') is-invalid @enderror" required autocomplete="email"/>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="password" name="password" placeholder="Пароль" class="in-auth @error('password') is-invalid @enderror" required/>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input class="log-in" type="submit" value="Войти">
            </div>
        </form>
    </div>
@endsection
