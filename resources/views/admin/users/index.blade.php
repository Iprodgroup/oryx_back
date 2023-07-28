@extends('layouts.admin')
@section('header')
	<div class="header header-users">
	    <div class="inner">
            <a href="/" class="logo"><img src="{{ asset('admin/images/logoadmin.png') }}"></a>
	         <div class="cms">CMS</div>
	    </div>
	</div>
@endsection
@section('content')


    <div class="content-wrap">

    	<div class="content">

    	    <div class="content-top">
                <div class="content-head_wrap">
                    <div class="content-head">
            	        Пользователи
            	    </div>

            	    <div class="content-text">
            	        Список пользователей
            	    </div>
                </div>
        	    <div class="flex flex-wrap align-center">


            	    <div class="search-wrap" >
            	        <form action="" method="">
            	            <div class="search-group">
            	                <button class="button-search" type="submit">
            	                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4137 9.22526H10.7554L10.5221 9.00026C11.3387 8.05026 11.8304 6.81693 11.8304 5.47526C11.8304 2.48359 9.4054 0.0585938 6.41374 0.0585938C3.42207 0.0585938 0.99707 2.48359 0.99707 5.47526C0.99707 8.46693 3.42207 10.8919 6.41374 10.8919C7.7554 10.8919 8.98874 10.4003 9.93874 9.58359L10.1637 9.81693V10.4753L14.3304 14.6336L15.5721 13.3919L11.4137 9.22526ZM6.41374 9.22526C4.33874 9.22526 2.66374 7.55026 2.66374 5.47526C2.66374 3.40026 4.33874 1.72526 6.41374 1.72526C8.48874 1.72526 10.1637 3.40026 10.1637 5.47526C10.1637 7.55026 8.48874 9.22526 6.41374 9.22526Z" fill="#333333"/></svg>
            	                </button>
            	                <input value="{{ request()->input('s') }}" type="text" name="s" placeholder="Найти пользователя" class="input-search" />
            	                <input type="hidden" name="status" value="{{ request()->input('status') }}">
            	            </div>
            	        </form>
            	    </div>

        	        <div class="buttons-top hide" style="left: 300px;right: auto;">
                		<form action="" id="status">
                        	{{ Form::select('status', array_replace(['Все статусы'], App\Models\Setting::tariffs()), request()->input('status')) }}
                        	<input type="hidden" name="s" value="{{ request()->input('s') }}">
                        </form>
                	</div>
                	<div class="buttons-top">
                        <form action="">
                        	<a class="createuser" href="{{route('users.create')}}">Добавить пользователя +</a>
                        </form>
                	</div>
        	    </div>
            </div>

    	    <form action="{{route('users.delete')}}" method="POST">
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
    	                    </td>
    	                    <td>
    	                        <div class="select-delete">
    	                            <p class="selected">Выбранo: <span class="count-delete">0</span></p>

    	                            <button type="submit" class="del">Удалить <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.98307 12.737C4.98307 13.4703 5.58307 14.0703 6.31641 14.0703H11.6497C12.3831 14.0703 12.9831 13.4703 12.9831 12.737V4.73698H4.98307V12.737ZM13.6497 2.73698H11.3164L10.6497 2.07031H7.31641L6.64974 2.73698H4.31641V4.07031H13.6497V2.73698Z" fill="#DC1E52"/></svg></button>
    	                        </div>
    	                    </td>
    	                    <td><p class="table-items">ФИО</p></td>
    	                    <td><p class="table-items">Email</p></td>
    	                    <td><p class="table-items">Телефон</p></td>
    	                    <td><p class="table-items ">Статус</p></td>
    	                    <td></td>
    	                    <td class="hide"></td>
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
    	                    <td>
    	                    	@if ($item->getMedia('avatars')->first())
    	                    		<img src="{{ $item->getMedia('avatars')->first()->getUrl('mini-thumb') }}" class="users">
    	                    	@endif
    	                    	{{$item->id}}
    	                    </td>
                            <td  style="max-width: 200px;">{{ $item->surname }} {{ $item->name }} {{ $item->fname }}</td>
    	                    <td  style="max-width: 200px;"><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
    	                    <td>{{$item->p}}</td>
    	                    <td class="">{{$item->tariffObj->name ?? ''}}</td>
    	                    <td>
    	                        <a class="usedit" href="{{route('users.edit', $item->id)}}">
    	                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.043 1.59729C15.6175 1.16844 15.0349 0.925781 14.4271 0.925781C13.8201 0.925781 13.2381 1.16789 12.8102 1.59841L5.04182 9.36667C4.34766 9.9783 3.89261 10.8884 3.81353 11.8672L3.81051 14.8516V15.7798H7.64842C8.70132 15.7076 9.6204 15.2481 10.2688 14.5002L17.9931 6.77912C18.4217 6.35057 18.6624 5.76934 18.6624 5.16328C18.6624 4.55722 18.4217 3.97598 17.9931 3.54743L16.043 1.59729ZM18.6625 17.6346V11.1369H16.806V17.6346H1.95414V2.78269H8.45183V0.926211H1.95414C0.928832 0.926211 0.0976562 1.75739 0.0976562 2.78269V17.6346C0.0976562 18.6599 0.928832 19.491 1.95414 19.491H16.806C17.8313 19.491 18.6625 18.6599 18.6625 17.6346ZM7.58287 13.9256C8.07876 13.8905 8.54035 13.6597 8.91101 13.2358L14.538 7.6088L11.9813 5.052L6.31315 10.7183C5.93707 11.051 5.70441 11.5163 5.667 11.942V13.9239L7.58287 13.9256ZM13.2943 3.73948L15.8507 6.29607L16.6804 5.46639C16.7608 5.386 16.8059 5.27697 16.8059 5.16328C16.8059 5.04959 16.7608 4.94056 16.6804 4.86017L14.7277 2.90744C14.6482 2.82733 14.54 2.78226 14.4271 2.78226C14.3143 2.78226 14.2061 2.82733 14.1266 2.90744L13.2943 3.73948Z" fill="#E65A57"/>
                                    </svg>
    	                        </a>

    	                        <a class="usedit hide" href="{{ route('parcels.index',['s'=>$item->id,'status'=>10]) }}">Посылки</a>
    	                    </td>

    	                    <td class="hide"><a class="usedit" href="{{ route('users.referal',$item->id) }}">Рефералы</a></td>
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
			$('#status select').change(function () {
				$('#status').submit();
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
		});
	</script>
@endsection
