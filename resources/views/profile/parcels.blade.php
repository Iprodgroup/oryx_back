@extends('layouts.app',[
    'title'=>'Мои посылки',
    'breadcrumbs'=>[
    route('profile.index')=>'Личный кабинет',
    url()->current()=>'Мои посылки'
    ],
])

@section('content')

    <x-profileNav></x-profileNav>

    <div class="container">

        <div class="mb-70px">
            <div class="title adress-count">
                Список ваших посылок
            </div>
            <p class="sub-adress">Вся информация о ваших посылках и их статусах</p>
        </div>


        @if (Session::has('order_nf_np'))
            <div class="alert alert-info mt-5">Не найдено неоплаченных посылок</div>
        @endif
        @if (Session::has('order_nf'))
            <div class="alert alert-info mt-5">Посылка не найдена</div>
        @endif
        @if (Session::has('order_payed'))
            <div class="alert alert-info mt-5">Посылка уже оплачена</div>
        @endif
        @if (Session::has('order_error'))
            <div class="alert alert-info mt-5">Ошибка при формировании платежа</div>
        @endif
        @if (Session::has('order_return_error'))
            <div class="alert alert-info mt-5">Ошибка при проверке платежа</div>
        @endif

        <div class="parcels-content">

            <div class="transact-nav row mb-50px">
                @foreach (__('ui.status') as $status_id=>$status)
                    <div class="col-lg-4 col-sm-6">
                        <a style="margin-bottom: 10px;" class="transact-link {{ $status_id==request()->input('status')?'active':'' }}" href="{{ route('profile.parcels') }}?status={{ $status_id }}">
                            <div>{{ $status }}</div>
                            <span>({{ Auth::user()->parcelStatusCount($status_id) }})</span>
                        </a>
                    </div>
                @endforeach
            </div>


            @if (count($items))


                <div class="content-added" style="width: 100%;">
                    @if (Session::has('not_found'))
                        <div class="alert alert-info">Посылка не найдена</div>
                    @endif
                    @if (Session::has('balance'))
                        <div class="alert alert-info">Недостаточно средств</div>
                    @endif
                    @if (Session::has('already_paid'))
                        <div class="alert alert-info">Посылка уже оплачена</div>
                    @endif
                    <div class="table-parcels">
                        <table class="partable table transact">
                            <thead>
                            <tr>
                                @if (request('status')==3 || request('status')==2)
                                    <td></td>
                                @endif
                                <td>Трек-код</td>
                                @if (request('status')>=4)
                                    <td>Трек-внутр.</td>
                                @endif
                                <td style="min-width: 100px">Статус</td>
                                {{-- <td>Наименование</td> --}}
                                <td>Получатель</td>
                                @if (request('status')!=4)
                                    <td>Страна доставки</td>
                                @endif
                                @if (request('status')!=0)
                                    <td>Вес(кг)/Габариты(см)</td>
                                @endif



                                @if (request('status')==0)
                                    <td></td>
                                @endif


                                <td>Страна отправки</td>
                                @if (request('status')==2)
                                    <td>Дата отправки</td>
                                @endif
                                @if (request('status')==4)
                                    <td>Стоимость</td>
                                @endif
                                @if (request('status')==6)
                                    <td>Стоимость</td>
                                @endif
                                @if (request('status')==5)
                                    <td>Стоимость</td>
                                @endif

                                @if (request('status')!=0)
                                    <td>Cтатус</td>
                                @endif



                                @if (request('status')==0)
                                    <td></td>
                                @endif
                                @if (request('status')==0)
                                    <td>Статус</td>
                                @endif


                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    @if (request('status')==3 || request('status')==2)
                                        <td>
                                            <label>
                                                <input type="checkbox" name="ids" class="circle-check" value="{{ $item->id }}">
                                                <span></span>
                                            </label>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="#more_{{ $item->id }}" class="more">{{ $item->track }}</a>
                                    </td>
                                    @if ($item->status>=4)
                                        <td>{{ $item->in_track }}</td>
                                    @endif
                                    <td>
                                        <div class="parcel_point">
                                            <img src="/images/point.svg">
                                            <span><span style="width: {{ request('status')==10?100:request('status')*20 }}%"></span></span>
                                        </div>
                                    </td>
                                    {{-- <td>{{ $item->name }}</td> --}}

                                    <td>
                                        @if ($item->status>=4)
                                            {{ $item->in_fio }}
                                        @else
                                            {{ $item->recipient->surname ?? '' }} {{ $item->recipient->name ?? '' }}
                                        @endif
                                    </td>
                                    @if (request('status')!=4)
                                        <td>{{ $item->country }}</td>
                                    @endif
                                    <td>
                                        {{ $item->weight }}
                                    </td>
                                    <td>
                                        {{ $item->from }}
                                    </td>

                                    @if ($item->status==2)
                                        <td>{{ $item->date_out?$item->date_out->format('d.m.Y'):'' }}</td>
                                    @endif

                                    @if ($item->status!=2)
                                        <td></td>
                                    @endif

                                    <td>
                                        @if ($item->status==2)
                                            @if ($item->payed)
                                                Оплачен
                                            @else
                                                <a href="{{ route('profile.parcels.pay',$item->id) }}">Оплатить</a>
                                            @endif
                                        @elseif($item->status==3 && $item->country_out==6)
                                            <a href="{{ route('profile.parcels.delivery',$item->id) }}" class="in_delivery">На доставку</a>
                                        @elseif(!$item->status)
                                            <div class="parcel-edit">
                                                <form method="post" action="{{ route('profile.parcels.delete',$item->id) }}">
                                                    @csrf
                                                    <button type="submit" class="icon-delete">
                                                        <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.945609 13.5272C0.945609 14.4342 1.68767 15.1762 2.59464 15.1762H9.19077C10.0977 15.1762 10.8398 14.4342 10.8398 13.5272V3.63302H0.945609V13.5272ZM11.6643 1.15948H8.77851L7.95399 0.334961H3.83141L3.0069 1.15948H0.121094V2.80851H11.6643V1.15948Z" fill="#BCBDBE"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr id="more_{{ $item->id }}" style="display: none">
                                    <td colspan="7">
                                        <div style="display: flex">
                                            @if (count($item->goods))
                                                <div style="margin-right: 50px;">
                                                    <p>Товары:</p>
                                                    @foreach ($item->goods as $good)
                                                        <p>{{ $good->name }} {{ $good->price }}{{ $good->currency }}</p>
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if (request('status')>=4)
                                                <div style="margin-right: 50px;">
                                                    <p>Получатель: {{ $item->recipient->surname ?? '' }} {{ $item->recipient->name ?? '' }}</p>                               <p>Номер посылки:{{ $item->in_track }}</p>
                                                    <p>Вес: {{ $item->weight }} </p>
                                                    <p>Стоимость доставки:{{ $item->prod_price }}$ </p>
                                                    <p>Город: </p>
                                                    <p>Адрес: {{ $item->in_address }}</p>
                                                    <p>Телефон: {{ $item->in_phone }}</p>
                                                    <p>Комментарий: {{ $item->in_comment }}</p>
                                                </div>
                                            @endif

                                            @if (request('status')>=2)
                                                <div>

                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    @if ($item->status==4)
                                        <td>{{ $item->prod_price }}$</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (request('status')==3)
                        <a href="{{ route('profile.parcels.deliveryMany') }}" class="btn modal-submit" style="width: auto; display: none;margin-top: 10px;line-height: 26px;" id="checked_d">Выделенные на доставку</a>
                    @endif
                    <a href="{{ route('profile.parcels.payMany') }}" class="btn modal-submit" style="width: auto; display: none;margin-top: 10px;line-height: 26px;" id="checked_p">Выделенные на оплату</a>
                </div>

                <div class="text-right">
                    <a href="{{ route('profile.parcels.create') }}" class="bt btn-orange add-parcel">Добавить посылку</a>
                </div>


            @else
                <div class="content-block">
                    <div class="empty">
                        <img src="/storage/images/box-default.png" class="empty-img">
                        <div class="empty-head">У вас еще нет посылок</div>
                        <a href="{{ route('profile.parcels.create') }}" class="bt btn-orange empty-btn add-parcel">Добавить посылку</a>
                    </div>
                </div>
            @endif
        </div>


    </div>

    <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-account">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-head">Добавить получателя</div>
                        <div class="modal-inputs">
                            <div class="modal-noflex">
                                <input type="text" name="in_fio" value="" placeholder="Фио получателя" required />
                            </div>
                            <div class="modal-noflex">
                                {{ Form::select('in_city', ['Алматы'=>'Алматы','Нур-Султан'=>'Нур-Султан','др. город'=>'др. город'], '',['class'=>'counrty-select c6', 'id'=>'city-select', 'style'=>'width: 100%;margin: 10px 0;','required'=>'required']) }}
                                {{-- <input type="text" name="in_city" value="" placeholder="Город" required style="margin: 10px 0;" /> --}}
                            </div>
                            <div class="modal-noflex" style="display: none">
                                <input type="text" id="city" name="" value="" placeholder="Город" style="margin-bottom: 10px;" />
                            </div>
                            <div class="modal-noflex">
                                <input type="text" name="in_address" value="" placeholder="Адрес полный" required />
                            </div>
                            <div class="modal-noflex">
                                <input type="text" name="in_phone" value="" placeholder="Телефон" required style="margin: 10px 0;" />
                            </div>
                            <div class="modal-noflex">
                                <textarea name="in_comment" cols="30" rows="10" placeholder="Комментарий" style="width: 100%;border: 1px solid #cccccc;background: #f0f0f0;font-size: 14px;font-weight: 500;height: 80px;padding-left: 10px;border-radius: 4px;"></textarea>
                            </div>
                            <div class="modbutton">
                                <button type="button" class="modal-cancel" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="modal-submit">На доставку</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('.in_delivery').click(function(e){
                e.preventDefault();
                $('#modal').modal();
                $('#modal form').attr("action", $(this).attr("href"));
            });

            $('#checked_d').click(function(e){
                e.preventDefault();
                var str = '';
                $('.circle-check:checked').each(function(i,o){
                    str += 'ids[]='+$(o).val()+'&';
                });
                $('#modal').modal();
                $('#modal form').attr("action", $(this).attr("href") + '?' + str);
            });

            $('#city-select').change(function(){
                if ($(this).val().indexOf('.')>=0) {
                    $('#city-select').removeAttr('name').prop('required',false);
                    $('#city').attr('name','in_city').prop('required',true).parent().show();
                }else{
                    $('#city').removeAttr('name').prop('required',false).parent().hide();
                    $('#city-select').attr('name','in_city').prop('required',true);
                }
            });

            $('.more').click(function(e){
                e.preventDefault();
                $($(this).attr('href')).toggle();
            });

            $('#checked_p').click(function(e){
                e.preventDefault();
                var str = '';
                $('.circle-check:checked').each(function(i,o){
                    str += 'ids[]='+$(o).val()+'&';
                });
                if(str) window.location = $(this).attr("href") + '?' + str;
            });
        });
    </script>
@endsection











