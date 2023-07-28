@extends('layouts.admin')
@section('content')


<div class="content-wrap">
    
    <div class="content">
        
        <div class="content-top">
            <div class="content-head_wrap">
                <div class="content-head">
        	        Администрирование
        	    </div>
        	    
        	    <div class="content-text">
        	        Список сотрудников
        	    </div>
            </div>
    	    <div class="buttons-top">
        		<!--<form action="">
                	<a class="createrole" href="{{route('roles.index')}}">Роли</a>
                </form>-->
                <form action="">
                	<a class="createuser" href="{{route('admins.create')}}">Добавить пользователя +</a>
                </form>
        	</div>
        </div>
    
        
        
        
	<div class="main-content">
	    <form action="{{route('admins.delete')}}" method="POST">
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
	                    <td>
	                        <p class="table-items">Email</p>
	                    </td>
	                    <td>
	                        <p class="table-items">Роль</p>
	                    </td>
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
	                    <td>
	                    	@if ($item->getMedia('avatars')->first())
	                    		<img src="{{ $item->getMedia('avatars')->first()->getUrl('mini-thumb') }}" class="admins">
	                    	@endif
	                    	{{$item->name}}
	                    </td>
	                    <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
	                    <td>{{ count($item->roles->toArray())?$item->roles[0]->title:'' }}</td>
	                    <td><a class="usedit" href="{{route('admins.edit', $item->id)}}">Редактировать</a></td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    </form>
	</div>
        
    </div>
    
</div>

	
	<script>
		$(function(){
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