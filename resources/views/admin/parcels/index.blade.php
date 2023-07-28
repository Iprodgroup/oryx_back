@extends('layouts.admin')
@section('header')
	<div class="header header-users">
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
	                <input type="hidden" name="status" value="{{ request()->input('status',0) }}">
	                <input type="hidden" name="city" value="{{ request()->input('city') }}">
	            </div>
	        </form>
	    </div>
	</div>
@endsection
@section('content')

	<?php /* ?><div class="buttons-top3">
		<form action="">
        	<a class="" href="{{route('parcels.create')}}">Добавить +</a>
        </form>
	    <form action="{{route('parcels.upload')}}" method="POST" enctype="multipart/form-data">
	    	@csrf
	    	<a href="/">Загрузить EXCEL +</a>
	    	<input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none;">
	    	<input type="submit" style="display: none;">
	    </form>
	</div><?php */ ?>

	<div class="content-wrap">
	    <div class="content">

    	    <div class="content-top">
                <div class="content-head_wrap">
                    <div class="content-head">
            	        Посылки
            	    </div>

            	    <div class="content-text">
            	     Список активных посылок
            	    </div>
                </div>
            	<div class="buttons-top">
            		<form action="">
                    	<a class="createuser" href="{{route('parcels.create')}}" style="margin-right: 10px;">+ Добавить </a>
                    </form>
                    <form action="{{route('parcels.upload')}}" method="POST" enctype="multipart/form-data">
            	    	@csrf
            	    	<a class="createrole snd_form btn-reverse" href="/">
            	    	    <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="10.7924" height="2" transform="matrix(1 0 0 -1 0.865234 2.58594)" fill="#E65A57"/>
                            <path d="M4.11591 9.51641V14.4219H8.53095V9.51641H11.781L6.29283 4.02827L0.804688 9.51641H4.11591Z" fill="#E65A57"/>
                            </svg>
            	    	    Загрузить EXCEL
            	    	</a>
            	    	<input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none;">
            	    	<input type="submit" style="display: none;">
            	    </form>
            	    <form>
            	    	<a class="createrole" href="{{route('parcels.load',array_merge(['status'=>request('status',0)],request()->except('status')))}}" >
            	    	    <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.384766" y="12.4219" width="10.7924" height="2" fill="#E65A57"/>
                            <path d="M3.63544 5.4914V0.585938H8.05048V5.4914H11.3005L5.81236 10.9795L0.324219 5.4914H3.63544Z" fill="#E65A57"/>
                            </svg>
            	    	    Скачать в excel
            	    	</a>
            	    </form>
            	</div>

            	<div class="buttons-top hide" style="width: 100%;  margin-top: 20px;">
            		<form action="{{route('parcels.index')}}" id="city">
                        @if (request('status',0)>=4 || request('out')==15)
                            {{ Form::select('in_city', ['Все города','Нур-Султан'=>'Нур-Султан','Алматы'=>'Алматы','др.города'], request('in_city')) }}
                        @else
                    	    {{ Form::select('city', ['Все города','Алматы'=>'Алматы','Нур-Султан'=>'Нур-Султан и др. города'], request()->input('city')) }}
                        @endif
                    	{{ Form::select('out', array_replace(['Все страны'],App\Models\Setting::where([['type',3],['active',1]])->pluck('name','id')->toArray()), request('out')) }}
                        @if (request('status',0)==4)
                            {{ Form::select('in_status', ['Все статусы','Не отправлена','Отправлена'], request('in_status')) }}
                        @endif
                        <div style="display: inline-block;margin-left: 50px;">
                            <label>c <input type="date" name="ds" value="{{ request('ds',now()->subMonth()->format('Y-m-d')) }}"></label>
                            <label>по <input type="date" name="de" value="{{ request('de',now()->format('Y-m-d')) }}"></label>
                        </div>
                    	<input type="hidden" name="s" value="{{ request()->input('s') }}">
                    	<input type="hidden" name="status" value="{{ request()->input('status',0) }}">
                    </form>
            	</div>

            </div>



        	<div class="parcels-menu">
        		@foreach (__('ui.status') as $key=>$status)
        			<li class="{{ request('status',0)==$key ? 'active' : '' }}"><a href="{{route('parcels.index',array_merge(['status'=>$key],request()->except('status')))}}">{{ $status }} ({{ isset($count[$key])?$count[$key]:0 }})</a></li>
        		@endforeach
        	</div>
    	    <form action="{{route('parcels.delete')}}" method="POST">
    	    	@csrf
    	        <table class="table tablebordered">
    	            <thead>
    	                <tr>
    	                    <td class="checks">
    	                        <div class="check-group">
    	                            <div class="custom-control custom-checkbox">
    	                                <input type="checkbox" class="custom-control-input checkbox" id="ch-all">
    	                                <label class="custom-control-label" for="ch-all"></label>
    	                            </div>
    	                            <svg width="5" height="4" viewBox="0 0 5 4" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 4L4.66506 0.25H0.334936L2.5 4Z" fill="#333333"/></svg>
    	                            <div class="buttons-hidden">
    	                                <button type="submit">Все (на этой странице)</button>
    	                                <button type="submit">Все (на всех страницах)</button>
    	                            </div>
    	                        </div>
    	                        <div class="select-delete">
        	                            <div class="hide selected"> Выбранo:  <span class="count-delete">0</span></div>
        	                            <button type="submit" class="del"> Удалить  <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.98307 12.737C4.98307 13.4703 5.58307 14.0703 6.31641 14.0703H11.6497C12.3831 14.0703 12.9831 13.4703 12.9831 12.737V4.73698H4.98307V12.737ZM13.6497 2.73698H11.3164L10.6497 2.07031H7.31641L6.64974 2.73698H4.31641V4.07031H13.6497V2.73698Z" fill="#DC1E52"/></svg></button>
        	                        </div>

    	                    </td>
    	                    <td style="max-width: 200px;">
    	                        оплата
    	                    </td>
    	                    <td><p class="table-items">UID</p></td>
    	                    <td><p class="table-items">Трек-номер</p></td>
    	                    <td class="hide"><p class="table-items">Номер посылки</p></td>
    	                    <td><p class="table-items">Дата</p></td>
    	                    <td><p class="table-items">Получатель</p></td>
                            @if (request('status')!=4)
    	                    <td ><p class="table-items">Страна</p></td>
                            @endif
    	                    <td><p class="table-items">Страна</p></td>
    	                    <td class="hide"><p class="table-items">Вес</p></td>
                            @if (request('status')==4)
    	                    <td><p class="table-items">Статус</p></td>
                            @endif
                            <td></td>
    	                </tr>
    	            </thead>
    	            <tbody>
    	            	@foreach($items as $item)
    	                <tr>
    	                    <td class="checks">
    	                        <div class="default-checkbox">
    	                            <input type="checkbox" class="custom-control-input checkbox" id="ch-only-{{$item->id}}" name="id[]" value="{{$item->id}}">
    	                            <label class="custom-control-label" for="ch-only-{{$item->id}}"></label>
    	                        </div>
    	                    </td>
    	                    <td class="nowrap">{{$item->payed?'Оплачена':'Не оплачена'}}</td>
    	                    <td class="nowrap">{{$item->user_id}}</td>
    	                    <td style="max-width: 150px;">{{$item->track}}</td>
    	                    <td class="hide">{{$item->pid}}</td>
    	                    <td class="nowrap">{{$item->created_at->format('d.m.Y')}}</td>
    	                    <td style="max-width: 200px;">
                                @if ($item->status==4 && request('out')!=15)
    	                    	<p class="parcels-content">{{ $item->recipient->surname ?? ''  }} {{ $item->recipient->name ?? ''  }} {{ $item->recipient->fname ?? ''  }}</p>
                                @endif
								@if ($item->status==3 && request('out')!=15)
    	                    	<p class="parcels-content">{{ $item->recipient->surname ?? ''  }} {{ $item->recipient->name ?? ''  }} {{ $item->recipient->fname ?? ''  }}</p>
                                @endif
								@if ($item->status==5 && request('out')!=15)
    	                    	<p class="parcels-content">{{ $item->recipient->surname ?? ''  }} {{ $item->recipient->name ?? ''  }} {{ $item->recipient->fname ?? ''  }}</p>
                                @endif
								@if ($item->status && request('out')!=15)
    	                    	<p class="parcels-content">{{ $item->recipient->surname ?? ''  }} {{ $item->recipient->name ?? ''  }} {{ $item->recipient->fname ?? ''  }}</p>
                                @endif
    	                    	@if (!$item->status==6 && request('out')!=15)
    	                    		#{{ $item->recipient->id ?? '' }} {{ $item->recipient->city ?? '' }}
    	                    	@endif
    	                    	@if ($item->status>=4 || request('out')==15)
    	                    	<div>
    	                    		@foreach (['in_fio','in_city','in_address','in_comment','in_phone'] as $element)
    	                    			@if ($item->{$element})
    	                    				<p>{{ $item->{$element} }}</p>
    	                    			@endif
    	                    		@endforeach
    	                    	</div>
    	                    	@endif
    	                    </td>
                            @if ($item->status==4)
    	                    <td>{{$item->country ?? '' }}</td>
                            @endif
    	                    <td>
                                @if ($item->status>=4 || request('out')==15)
                                    {{$item->in_city }}
                                @else
                                    {{$item->city ?? '' }}
                                @endif
                            </td>
    	                    <td class="hide">{{$item->weight}}</td>
                            @if (request('status')==4)
                                <td>{{$item->in_status?'Отправлена':'Не отправлена'}}</td>
                            @endif
                            <td>
                                <div class="parcels-links">
    	                            <a class="edit" href="{{route('parcels.edit', $item->id)}}">
        	                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4024 1.53479C15.9769 1.10594 15.3943 0.863281 14.7865 0.863281C14.1794 0.863281 13.5975 1.10539 13.1695 1.53591L5.4012 9.30417C4.70703 9.9158 4.25198 10.8259 4.1729 11.8047L4.16989 14.7891V15.7173H8.0078C9.0607 15.6451 9.97977 15.1856 10.6281 14.4377L18.3525 6.71662C18.781 6.28807 19.0218 5.70684 19.0218 5.10078C19.0218 4.49472 18.781 3.91348 18.3525 3.48493L16.4024 1.53479ZM19.0219 17.5721V11.0744H17.1654V17.5721H2.31351V2.72019H8.8112V0.863711H2.31351C1.28821 0.863711 0.457031 1.69489 0.457031 2.72019V17.5721C0.457031 18.5974 1.28821 19.4285 2.31351 19.4285H17.1654C18.1907 19.4285 19.0219 18.5974 19.0219 17.5721ZM7.94225 13.8631C8.43813 13.828 8.89973 13.5972 9.27038 13.1733L14.8974 7.5463L12.3407 4.9895L6.67252 10.6558C6.29644 10.9885 6.06379 11.4538 6.02637 11.8795V13.8614L7.94225 13.8631ZM13.6537 3.67698L16.2101 6.23357L17.0398 5.40389C17.1202 5.3235 17.1653 5.21447 17.1653 5.10078C17.1653 4.98709 17.1202 4.87806 17.0398 4.79767L15.0871 2.84494C15.0076 2.76483 14.8994 2.71976 14.7865 2.71976C14.6736 2.71976 14.5655 2.76483 14.486 2.84494L13.6537 3.67698Z" fill="#E65A57"/>
                                        </svg>
    	                            </a>
    	                        </div>
                            </td>
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
