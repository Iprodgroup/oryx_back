@extends('layouts.app',[
    'title'=>'Настройки аккаунта',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Настройки аккаунта'
    ],
])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">


        <div class="blocks-flex">
            <div class="personal-date">
                <div class="pers-line">
                    <div class="title adress-count">
                        Личные данные пользователя
                    </div>
                    <p class="sub-adress">В данном разделе собрана вся ваша персональная информация</p>

                </div>
            </div>


            <div class="count-flex flex flex-wrap between">

                <div class="w-49prec">
                    <div class="whitebox">
                        <div class="flex flex-wrap between" style="margin-bottom: 20px;">
                            <div class="title20">Мои данные</div>
                            <div class="persid">ID: #{{ Auth::user()->id }}</div>
                        </div>

                        <form method="POST" action="{{ route('profile.settings') }}">
                            @csrf
                            <div class="perso-in">
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="text" name="surname"
                                                                                           value="{{ Auth::user()->surname }}"
                                                                                           placeholder="Фамилия*"
                                                                                           required/></div>
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="text" name="name"
                                                                                           value="{{ Auth::user()->name }}"
                                                                                           placeholder="Имя*" required/>
                                </div>
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="text" name="fname"
                                                                                           value="{{ Auth::user()->fname }}"
                                                                                           placeholder="Отчество"/>
                                </div>
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="text" name="email"
                                                                                           value="{{ Auth::user()->email }}"/>
                                </div>
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="text" name="phone"
                                                                                           value="{{ Auth::user()->phone }}"/>
                                </div>
                                <div class="adress-ex" style="margin-bottom: 20px;"><input type="password"
                                                                                           name="password"
                                                                                           placeholder="Пароль"/></div>

                                <div class="pers-buttons">
                                    <button type="submit" class="bt btn-orange">Сохранить изменения</button>
                                    <a href="{{ route('profile.index') }}" class="bt btn-cancel">Отменить изменения</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="w-49prec">
                    <div class="acc-recepients whitebox">
                        <div class="rec-block">
                            <div class="title20" style="margin-bottom: 20px;">Получатели</div>
                            <div style="margin-bottom: 20px;">Добавить получателя</div>
                            @foreach (Auth::user()->recipients as $recipient)
                                <form method="" action="">
                                    <div class="confirm-input">
                                        <div class="no-confirm">
                                            <p class="conf-none">
                                                @if ($recipient->confirm)
                                                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="11.3639" cy="11.7765" r="9.98698" stroke="#22AD28"
                                                                stroke-width="2"/>
                                                        <path d="M7.75586 12.3501L11.3841 14.6416L14.8215 8.9126"
                                                              stroke="#22AD28" stroke-width="2"/>
                                                    </svg>
                                                    Подтвержден
                                                @else
                                                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12.4111 16.7769H10.2871V8.85205H12.4111V16.7769ZM10.1626 6.80127C10.1626 6.48389 10.2676 6.22266 10.4775 6.01758C10.6924 5.8125 10.9829 5.70996 11.3491 5.70996C11.7104 5.70996 11.9985 5.8125 12.2134 6.01758C12.4282 6.22266 12.5356 6.48389 12.5356 6.80127C12.5356 7.12354 12.4258 7.38721 12.2061 7.59229C11.9912 7.79736 11.7056 7.8999 11.3491 7.8999C10.9927 7.8999 10.7046 7.79736 10.4849 7.59229C10.27 7.38721 10.1626 7.12354 10.1626 6.80127Z"
                                                            fill="#656565"/>
                                                        <circle cx="11.3639" cy="11.7765" r="9.98698" stroke="#656565"
                                                                stroke-width="2"/>
                                                    </svg>

                                                    Не подтвержден
                                                @endif
                                            </p>
                                            <p class="conf-none"
                                               style="border: none;">{{ $recipient->surname }} {{ $recipient->name }} {{ $recipient->fname }}</p>
                                        </div>
                                        {{-- <button type="submit">Подтвердить</button> --}}
                                    </div>
                                </form>
                            @endforeach
                        </div>
                        @if (session('recipient'))
                            <div class="alert alert-success" style="margin-top: 20px;">
                                Спасибо, ваша заявка отправлена на проверку. Вам придет оповещение после модерации нашим
                                специалистом, а тем временем Вы можете добавлять посылки
                            </div>
                        @endif
                        <div class="add-rec">
                            <button class="toggle-modal bt btn-orange" data-toggle="modal" data-target="#modal">Добавить
                                получателя
                            </button>
                        </div>
                    </div>
                </div>

            </div>


        </div>


    </div>

    <div id="modal" class="modal-fon modal fade" role="dialog">
        <div class="modal-dialog modal-account">
            <div class="modal-content">
                <button type="button" class="close close-orange" data-dismiss="modal" aria-label="Close">
                    <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20.7453" cy="20.7375" r="20.1056" fill="#E65A57"/>
                        <path d="M14.1367 14.1289L27.3533 27.3456" stroke="white" stroke-width="3"/>
                        <path d="M27.3535 14.1289L14.1369 27.3456" stroke="white" stroke-width="3"/>
                    </svg>
                </button>
                <div class="modal-body">
                    <form method="POST" action="{{ route('profile.recipients.add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="title20" style="margin-bottom: 20px;">Добавить получателя</div>
                        <div style="margin-bottom: 20px;">Для того чтобы добавить получателя, обязательно заполните все
                            поля помеченные *
                        </div>
                        <div class="modal-inputs">
                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="name" placeholder="Имя*" required/>
                                <input type="text" name="surname" placeholder="Фамилия*" required/>
                            </div>
                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="fname" placeholder="Отчество"/>
                                <select name="country" placeholder="Страна*" required>
                                    <option selected value="Казахстан">Казахстан</option>
                                    <option value="Россия">Россия</option>
                                </select>
                            </div>
                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="pnum" value="" placeholder="Номер удостоверения личности*"
                                       required/>
                                <input type="text" name="pby" value="" placeholder="Кем выдано*" required/>
                            </div>
                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="pdate" value="" placeholder="Дата выдачи*" required
                                       style="width: 100%;"/>
                            </div>

                            <div class="modal-information" style="font-size: 14px; margin-bottom: 20px;">
                                Прикрепите скан или фото обеих сторон удостоверения личности отдельными файлами в
                                формате jpg, png
                            </div>
                            <div class="modal-file_wrap flex flex-wrap between">
                                <div class="modal-file">
                                    <label>Прикрепить сторону А *</label>
                                    <input type="file" name="file1" accept=".png, .jpg" required>
                                </div>
                                <div class="modal-file">
                                    <label>Прикрепить сторону Б *</label>
                                    <input type="file" name="file2" accept=".png, .jpg" required>
                                </div>
                            </div>

                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="phone" value="" placeholder="+7 (...) *" required/>
                                <input type="text" name="city" value="" placeholder="Город*" required/>
                            </div>
                            <div class="modal-flex flex flex-wrap between">
                                <input type="text" name="address" value="" placeholder="Адрес*" required
                                       style="width: 100%"/>
                            </div>

                            <!---<div class="modal-download">
                                <a href="#" download class="link-doc">Скачать договор
                                    <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.750732" y="12.2949" width="10.7924" height="2" fill="#DC1E52"/>
                                    <path d="M4.00067 5.36592V0.460449H8.41571V5.36592H11.6657L6.1776 10.8541L0.689453 5.36592H4.00067Z" fill="#DC1E52"/>
                                    </svg>
                                </a>
                                 заполните и подпишите его ВРУЧНУЮ, а потом загрузите скан или фото договора в формате jpg, png, pdf
                            </div>--->
                            {{-- <div class="modal-doc">
                                <input type="file" name="file3" required>
                            </div> --}}
                            <div class="modbutton">
                                <button type="submit" class="modal-submit bt btn-orange">Сохранить</button>
                                <button type="button" class="modal-cancel btn-cancel bt" data-dismiss="modal">Отмена
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection











