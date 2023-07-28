@php
  $title = 'Данные пользователя';
@endphp
@extends('layouts.admin')
@section('content')
	<form method="POST" enctype="multipart/form-data" action="{{$item->id?route('users.update', $item->id):route('users.store', $item->id)}}">
		@csrf
        @if($item->id)
          @method('PUT')
        @endif
	    
	    <div class="content-wrap">
	        <div class="buttons-top">
    	        <button type="submit" class="save">  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.26764 0.490234H13.0988L15.7858 3.25151V14.0084C15.7858 14.8379 15.1133 15.5104 14.2838 15.5104H2.26764C1.4381 15.5104 0.765625 14.8379 0.765625 14.0084V1.99225C0.765625 1.16271 1.4381 0.490234 2.26764 0.490234ZM12.0301 1.99243V6.49848H4.51998V1.99243H2.26696V14.0085H3.76897V8.00049H12.7811V14.0085H14.2831V3.86188L12.464 1.99243H12.0301ZM6.02202 4.99646V1.99243H10.5281V4.99646H6.02202ZM5.27135 9.50256V14.0086H11.2794V9.50256H5.27135ZM9.77776 2.7431H8.27575V4.24511H9.77776V2.7431Z" fill="white"/></svg>Сохранить</button>
    	        <a class="go-back" href="{{route('users.index')}}"> <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.734375 7.99988L9.49987 15.6697V11.2264C12.258 10.9323 14.5383 11.7168 16.4106 13.5891L17.8332 15.0117V12.9999C17.8332 7.7786 14.9571 4.94273 9.49987 4.68574V0.330078L0.734375 7.99988ZM3.26537 7.9999L7.83322 4.00304V6.33323H8.66655C13.0004 6.33323 15.3753 7.87575 15.9988 11.097C13.8795 9.67865 11.375 9.20365 8.52955 9.6779L7.83322 9.79396V11.9968L3.26537 7.9999Z" fill="white"/></svg>Назад</a>
    	    </div>
    	    <div class="content content-inner">
    	        <div class="profiles">
    	            <div class="flex flex-wrap between align-center">
    	                
    	                <div class="prof-head">{{ $title }}</div>
        	            @if ($item->id)
                        	<div class="user-id">ID: <span style="color: #333333;">#{{ $item->id }}</span></div>
                        @endif
    	                
    	            </div>
    	            
    	            
    	            <div class="prof-inputs flex flex-wrap">
    	                
    	                <div class="new-flex w-two">
    	                    <p class="input-name">Имя</p>
    	                    <input type="text" name="name" class="input-withid" value="{{ old('name', $item->name) }}" placeholder="Введите имя" />
    	                    
    	                    @error('name')
    				            <span class="invalid-feedback" role="alert">
    				              <strong>{{ $message }}</strong>
    				            </span>
    				        @enderror
    	                </div>
    	                
    	                <div class="new-flex w-one">
    	                    <p class="input-name ">Email</p>
    	                    <input type="email" name="email" value="{{ old('email', $item->email) }}" placeholder="Введите email" />
    	                    @error('email')
    				            <span class="invalid-feedback" role="alert">
    				              <strong>{{ $message }}</strong>
    				            </span>
    				        @enderror
    	                </div>
    	                <div class="new-flex w-two">
    	                    <p class="input-name ">Телефон</p>
    	                    <input type="text" name="phone" value="{{ old('phone', $item->phone) }}" placeholder="Введите телефон" />
    	                    @error('phone')
    				            <span class="invalid-feedback" role="alert">
    				              <strong>{{ $message }}</strong>
    				            </span>
    				        @enderror
    	                </div>
    	                <div class="new-flex w-one">
    	                    <p class="input-name ">Пароль</p>
    	                    <input type="password" name="password" placeholder="введите пароль" @if(!$item->id) required @endif />
    	                    @error('password')
    				            <span class="invalid-feedback" role="alert">
    				              <strong>{{ $message }}</strong>
    				            </span>
    				        @enderror
    	                </div>
    	                <div class="new-flex hide">
    	                    <p class="input-name">Статус</p>
    	                    {{ Form::select('tariff_id', App\Models\Setting::tariffs(),$item->tariff_id) }}
    	                </div>
    	                <div class="new-flex hide">
    	                    <p class="input-name">Баланс</p>
    	                    <input type="text" name="balance" value="{{ old('balance', $item->balance) }}" class="balance" />
    	                </div>
    	                <div class="new-flex hide">
    	                    <p class="input-name">Кэшбек</p>
    	                    <input type="text" name="cashback" value="{{ old('cashback', $item->cashback) }}" class="balance" />
    	                </div>
    	                <div class="new-flex w-two">
    	                    <p class="input-name ">Адрес(буквы)</p>
    	                    <input type="text" name="address" value="{{ old('address', $item->address) }}" class="" />
    	                </div>
    	                <div class="new-flex hide">
    			            <p class="input-name">Реферал</p>
    			            <input type="hidden" name="ref_id" id="ref_id" value="{{ old('ref_id', $item->ref_id) }}" />
    			            <input type="text" id="referal" value="@if ($item->ref_id){{ $item->ref->surname ?? '' }} {{ $item->ref->name ?? '' }} {{ $item->ref->fname ?? '' }} ({{$item->tariffObj->name}}) UID{{ $item->ref_id }}@endif" />
    			        </div>
    	            </div>
    	        </div>
    	    </div>
	    </div>
	    
	</form>
	<script>
		$(function(){
		    $("#referal").autocomplete({
		      source: "{{ route('ajax.user') }}",
		      minLength: 1,
		      select: function( event, ui ) {
		      	$('#ref_id').val(ui.item.user);
		      }
		    });
		});
	</script>
@endsection
