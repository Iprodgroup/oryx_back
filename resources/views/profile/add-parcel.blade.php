@extends('layouts.app',[
    'title'=>'Добавить посылку',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    route('profile.parcels')=>'Мои посылки',
    url()->current()=>'Добавить посылку'
    ],
])

<x-profileNav></x-profileNav>

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="container">

        <div class="count-flex flex flex-wrap between">

            <div class="title" style="width: 100%;">
                Добавление посылки
            </div>

            <div class="title-text mb-70px" style="width: 100%;">
                После оформления данных о посылке нажмите «Добавить посылку». Также не забудьте добавить получателя.
            </div>

            <div class="main-block-adress">
                <form method="POST" action="{{ route('profile.parcels.store') }}">
                    @csrf


                    <div class="create-flex_wrap flex flex-wrap between" style="max-width: 650px">

                        <div class="create-flex" style="max-width: 165px">
                            <p class="input-item">Страна отправки</p>
                            {{ Form::select('country_out', App\Models\Setting::where([['type',3],['active',1]])->pluck('name','id'),  old('country_out'),['class'=>'counrty-select','id'=>'country_out']) }}
                        </div>
                        <div id="eu" style="display: none">
                            <div class="create-flex">
                                <p class="input-item">Фио получателя</p>
                                <input type="text" name="in_fio" value="{{ old('in_fio') }}"
                                       placeholder="Фио получателя"
                                       class="style-input num-tracking @error('in_fio') is-invalid @enderror"/>
                            </div>
                            <div class="create-flex">
                                <p class="input-item">Город</p>
                                <input type="text" name="in_city" value="{{ old('in_city') }}" placeholder="Город"
                                       class="style-input num-tracking @error('in_city') is-invalid @enderror"/>
                            </div>
                            <div class="create-flex">
                                <p class="input-item">Адрес полный</p>
                                <input type="text" name="in_address" value="{{ old('in_address') }}"
                                       placeholder="Адрес полный"
                                       class="style-input num-tracking @error('in_address') is-invalid @enderror"/>
                            </div>
                            <div class="create-flex">
                                <p class="input-item">Телефон</p>
                                <input type="text" name="in_phone" value="{{ old('in_phone') }}" placeholder="Телефон"
                                       class="style-input num-tracking @error('in_phone') is-invalid @enderror"/>
                            </div>
                        </div>
                        <div class="create-flex" style="max-width: 165px">
                            <p class="input-item">Страна доставки</p>
                            {{ Form::select('country', $countries_out, old('country'),['class'=>'counrty-select']) }}
                        </div>
                        <div class="create-flex" style="max-width: 280px">
                            <p class="input-item c6">Город доставки</p>
                            {{ Form::select('city', $cities, old('city'),['class'=>'counrty-select c6']) }}
                        </div>
                        <div class="create-flex" style="max-width: 345px">
                            <p class="input-item">Номер трекинга</p>
                            <input type="text" name="track" value="{{ old('track') }}" placeholder="Номер трекинга"
                                   class="style-input num-tracking @error('track') is-invalid @enderror" required/>
                            @error('track')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="create-flex" style="max-width: 280px">
                            <p class="tracking-info">Трекинг-номер – это не номер заказа, а номер, по которому
                                отслеживается доставка посылки в курьерской службе.</p>

                        </div>

                        <div class="create-flex" id="goods" style="width: 100%;">
                            <div class="good good-flex flex flex-wrap between" style="align-items: flex-end;">

                                <div style="max-width: 345px; width: 100%">
                                    <p class="input-item">Декларация</p>
                                    <input type="text" name="goods[name][]" value="" placeholder="Наименование"
                                           class="style-input declarat" required/>
                                    {{-- @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>

                                <div style="max-width: 65px">
                                    <p class="input-item"></p>
                                    <select name="goods[currency][]" class="curr-select good_currency">
                                        <option selected value="$">$</option>
                                        <option value="€">€</option>
                                    </select>

                                </div>

                                <div style="max-width: 200px;">
                                    <p class="input-item">Стоимость</p>
                                    <input name="goods[price][]" type="text" value="" placeholder="Введите сумму"
                                           class="style-input col-vo-input good_price" required/>
                                </div>
                                <div class="create-flex" style="max-width: 345px">


                                </div>


                                <div class="itog" style="width: 100%;">
                                    <div style="max-width: 65px">

                                        <input type="checkbox" onclick="window.myDialog.showModal();"/>
                                        <dialog id="myDialog">“ВНИМАНИЕ
                                            Услуга переупаковки/убрать дополнительную коробку от производителя является
                                            ПЛАТНОЙ.

                                            Стоимость составляет 2$ за 1 трек номер.

                                            Товары электроники, техники, косметики переупаковке НЕ подлежат”
                                            <input id="check" type="checkbox" onclick="window.myDialog.close();"/>
                                            <center>Потвердить</center>
                                        </dialog>


                                        <div class="create-flex" style="max-width: 280px">Переупокавать/Убрать
                                            дополнительную упаковку <p class="tracking-info"></p>
                                            <p class="input-item"></p>
                                            <div class="create-flex" style="max-width: 280px">

                                                <fieldset>
                                                    <legend></legend>
                                                    <div>
                                                        <input type="hidden" id="puF4" type="goods[price][]"
                                                               name="prod_price" value="0"/>


                                                    </div>


                                                    <script>

                                                        var txt = document.getElementById('puF4'),
                                                            check = document.getElementById('check');


                                                        check.onchange = function () {

                                                            txt.value = (this.checked) ? 2 : 0;

                                                        };

                                                    </script>

                                                </fieldset>

                                            </div>
                                            </select>
                                            <p class="value"><b>Итого:</b> <span class="title24">0.0$</span></p>

                                            <a href="#" class="remove" style="display: none;">Удалить</a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <p class="value"><b></b> <span class="goods[price][]"></span></p>

                        <div class="attention" style="max-width: 650px;">

                            <p>Во избежание проблем при таможенной очистке, просим вводить детальное описание
                                наименования товара на русском.</p>
                            <p>С 1 января 2020 года были сняты ограничение по ввозу товаров для личного пользования в
                                адрес одного физлица.</p>
                            <p>При каждом отправлении можно будет ввозить без уплаты таможенных пошлин товары, стоимость
                                которых не превышает 200 евро и/или вес которых не превышает 31 кг.</p>
                            <p>При превышении установленных норм необходимо будет уплатить таможенный платеж по ставке
                                15% от стоимости или 2 евро за 1 каждый лишний килограмм.</p>

                        </div>


                        <div class="add-prod">
                            <button type="button" class="add bt btn-orange" id="add">Добавить еще один товар</button>
                        </div>
                        <div class="poluchatel mb-30px">
                            <p class="input-item">Получатель</p>
                            @if (count($recipients))
                                {{ Form::select('recipient_id', $recipients, false, ['class'=>'curr-select','required','oninvalid'=>"this.setCustomValidity('Выберите получателя из списка или добавьте нового получателя')"]) }}
                            @else
                                <p>Чтобы забрать посылки в Казахстане, добавьте <a
                                        href="{{ route('profile.settings') }}">получателя</a></p>
                            @endif
                        </div>


                        <div class="under-buttons">
                            <button type="submit" class="add-succ bt btn-orange">Добавить посылку</button>
                            <a href="{{ route('profile.parcels') }}" class="bt btn-cancel">Отменить</a>
                        </div>


                </form>

            </div>


            <div class="right-adresses">
                <div class="vazhno">
                    <div class="vazhno-head">ВНИМАНИЕ</div>
                    <p>При заказе на сайтах, слитно с фамилией укажите ваш город AST или ALA. Например:</p>
                    <p>OspanovALA (ALA &ndash; если вам нужна доставка в Алматы или AST - если вам нужна доставка в
                        Нур-Султан и во все остальные города).</p>
                    <p>*ВНИМАНИЕ!* заказы без маркировки города будут отправляться в г. Нур-Султан по умолчанию!</p>
                </div>
            </div>


        </div>


    </div>

@endsection
@section('script')
    <script>
        $(function () {
            countryOut();
            $('#country_out').change(function () {
                countryOut();
            });

            function countryOut() {
                if (parseInt($('#country_out').val()) == 6) {
                    $('#eu').hide();
                    $('.c6').show();
                    $('#eu input').prop('required', false);
                } else {
                    $('#eu').show();
                    $('.c6').hide();
                    $('#eu input').prop('required', true);
                }
            }

            $('#add').click(function () {
                var $clone = $('#goods .good').eq(0).clone();
                $clone.find('input').val('');
                $('#goods .value').hide();
                $('#goods .remove').show();

                $clone.find('.value').show();
                $clone.find('.remove').hide();

                $clone.appendTo("#goods");
                calc();
            });

            $('#goods').on('click', '.remove', function (e) {
                e.preventDefault();
                $(this).parents('.good').remove();
                calc();
            });

            var kg_price = {!! json_encode(Auth::user()->tariff) !!};
            $('#goods').on('change', '.good_currency', function () {
                calc();
            });
            $('#goods').on('keyup', '.good_price', function () {
                $(this).val($(this).val().replace(',', '.'));
                calc();
            });

            function calc() {
                var total = 0;
                $('#goods .good').each(function (i, o) {
                    var price = parseFloat($(o).find('.good_price').val());
                    if (!price) price = 0;
                    if ($(o).find('.good_currency').val() != '$')
                        price = Math.ceil(price + (price / 100 * 22));
                    total += price;
                });

                /*var weight = Math.ceil(parseFloat($('#weight').val())*10)/10;
                if(!weight)
                    weight = 0;
                if($('[name=currency]').val() != '$'){
                    weight = Math.ceil(weight-(weight/100*22));
                }
                console.log(weight);
                $('.itog span').html(weight*kg_price+$('[name=currency]').val());*/
                $('.itog span').html(total + '$');
            }
        });
    </script>
@endsection
