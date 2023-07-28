@extends('layouts.admin')
@section('header')
	<div class="header header-users" style="top: 0">
	    <div class="inner">
            <a href="/" class="logo"><img src="{{ asset('admin/images/logoadmin.png') }}"></a>
	         <div class="cms">CMS</div>
	    </div>
	    <div class="search">
	        <form action="" method="">
	            <div class="search-group">
	                <input type="text" value="{{ request()->input('s') }}" name="s" placeholder="ID Пользователя или трек" class="input-search" />
	                <button class="button-search" type="submit"><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4137 9.22526H10.7554L10.5221 9.00026C11.3387 8.05026 11.8304 6.81693 11.8304 5.47526C11.8304 2.48359 9.4054 0.0585938 6.41374 0.0585938C3.42207 0.0585938 0.99707 2.48359 0.99707 5.47526C0.99707 8.46693 3.42207 10.8919 6.41374 10.8919C7.7554 10.8919 8.98874 10.4003 9.93874 9.58359L10.1637 9.81693V10.4753L14.3304 14.6336L15.5721 13.3919L11.4137 9.22526ZM6.41374 9.22526C4.33874 9.22526 2.66374 7.55026 2.66374 5.47526C2.66374 3.40026 4.33874 1.72526 6.41374 1.72526C8.48874 1.72526 10.1637 3.40026 10.1637 5.47526C10.1637 7.55026 8.48874 9.22526 6.41374 9.22526Z" fill="#333333"/></svg>
	                </button>
	            </div>
	        </form>
	    </div>
	</div>
@endsection
@section('content')


    <div class="content-wrap">
        <div class="content">

    	    <div class="content-top">
                <div class="content-head_wrap">
                    <div class="content-head">
            	        Транзакции
            	    </div>

            	    <div class="content-text">
            	        Список проведенных транзакций
            	    </div>
                </div>
        	    <div class="buttons-top" style="left: 300px;right: auto;">
                    <form action="" id="city">
                        <input type="hidden" name="s" value="{{ request('s') }}">
                        <div style="display: inline-block">
                            <label>c <input type="date" name="ds" value="{{ request('ds') }}"></label>
                            <label>по <input type="date" name="de" value="{{ request('de') }}"></label>
                        </div>
                    </form>
                </div>
            </div>


    	    <form action="{{route('parcels.delete')}}" method="POST">
    	    	@csrf
    	        <table class="table tablebordered">
    	            <thead>
    	                <tr>
    	                    <td><p class="table-items">id платежа</p></td>
    	                    <td><p class="table-items">Код банка</p></td>
                            <td><p class="table-items">Пользователь</p></td>
                            <td><p class="table-items">Трек</p></td>
    	                    <td><p class="table-items">Дата</p></td>
    	                    <td><p class="table-items">сумма USD</p></td>
    	                    <!--<td><p class="table-items">Тенге</p></td>-->
    	                    <!--<td><p class="table-items">Баланс</p></td>-->
    	                </tr>
    	            </thead>
    	            <tbody>
    	            	@foreach($items as $item)
    	                <tr>
                            <td style="font-weight: 700">{{$item->id}}</td>
                            <td>{{$item->order}}</td>
                            <td>
                                @can('users')
                                    <a class="usedit" href="{{route('users.edit', $item->user_id)}}">{{$item->user_id }}</a>
                                @else
                                    {{$item->user_id }}
                                @endcan
                            </td>
    	                    <td>
                                {{$item->parcel->track ?? ''}}
                                @foreach ($item->parcels as $parcel)
                                    {{$parcel->track}}<br>
                                @endforeach
                            </td>
    	                    <td>{{$item->created_at->format('d.m.Y')}}</td>
    	                    <td>{{$item->count}}</td>
    	                    <td class="hide">{{$item->tenge}}</td>
                            <td class="hide" style="font-weight: normal">{{$item->user->balance ?? ''}}</td>
    	                </tr>
    	                @endforeach
    	            </tbody>
    	        </table>
    	    </form>
            {{ $items->links() }}
    	</div>


    </div>

	<script>
		$(function(){
			$('#city select,#city input').change(function () {
				$('#city').submit();
			});
		    $('#ch-all').change(function () {
		      if($(this).is(':checked')){
		        $('tbody .checks .checkbox').prop('checked',true);
		      }else{
		        $('tbody .checks .checkbox').prop('checked',false);
		      }
		      $('.count-delete').html($('tbody .checks .checkbox:checked').length);
		    });

		    $('tbody .checks .checkbox').change(function () {
		      if($('tbody .checks .checkbox').length == $('tbody .checks .checkbox:checked').length)
		        $('#ch-all').prop('checked',true);
		      else
		        $('#ch-all').prop('checked',false);
		      $('.count-delete').html($('tbody .checks .checkbox:checked').length);
		    });

		    $('button.delete').click(function(){
		    	$('#ch-only-'+$(this).data('id')).prop('checked',true);
		    	$(this).parents('form').submit();
		    });

		    $('.buttons-top .snd_form ').click(function(e){
		    	e.preventDefault();
		    	$(this).next().click();
		    });

		    $(".buttons-top [name=file]").change(function () {
			    $(this).next().click();
			});
		});
	</script>
@endsection
