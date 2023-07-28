@extends('layouts.app',[
    'title'=>'Регистрация завершена',
    'breadcrumbs'=>[
    url()->current()=>'Регистрация завершена'
    ],
])

@section('content')
<div class="container" style="margin-top: 70px;">
    
    <div class="confirmed-mail whitebox mx-auto" style="width: 100%;max-width: 600px;">
        <div class="confirm-head">Регистрация успешно завершена!</div>
        <p class="sub-conf">Благодарим за регистрацию на сайте. Теперь вы можете воспользоваться всеми преимуществами сайта.</p>
        <div class="personal-link view-all">
            <a href="{{ route('profile.index') }}">Перейти в личный кабинет</a>
        </div>
    </div>
    
</div>
@endsection
