@extends('layouts.admin')
@section('content')

 
	<div class="content-wrap">
	    
	    <div class="content-top">
            <div class="content-head_wrap">
                <div class="content-head">
        	        Настройки
        	    </div>
        	    
        	    <div class="content-text">
        	       Редактировать шаблоны писем, страну доставки/отправки и тарифы
        	    </div>
            </div>
    	    <!--<div class="buttons-top">
                <form action="">
                	<a class="createuser" href="{{route('settings.create',['type'=>$type])}}">Добавить +</a>
                </form>
        	</div>-->
        </div>
	    
	    <div class="content"> 
    	    
    		<div class="settings-content">
    		    <div class="set-head">
        	        <a href="{{route('settings.index')}}" class="templates {{ $type?'':'active' }}">Шаблоны писем</a>
        	        <a href="{{route('settings.index',['type'=>2])}}" class="templates {{ $type==2?'active':'' }}">Страна доставки</a>
        	        <a href="{{route('settings.index',['type'=>3])}}" class="templates {{ $type==3?'active':'' }}">Страна отправки</a>
        	        <a href="{{route('settings.index',['type'=>4])}}" class="templates {{ $type==4?'active':'' }}">Тарифы</a>
        	    </div>
    	        <form action="{{route('settings.delete')}}" method="POST">
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
    	                        </div>
    	                    </td>
    	                    <td>
    	                        <div class="select-delete">
    	                            <p class="selected">Выбранo: <span class="count-delete">0</span></p>
    	                            <button type="submit" class="del">Удалить <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.98307 12.737C4.98307 13.4703 5.58307 14.0703 6.31641 14.0703H11.6497C12.3831 14.0703 12.9831 13.4703 12.9831 12.737V4.73698H4.98307V12.737ZM13.6497 2.73698H11.3164L10.6497 2.07031H7.31641L6.64974 2.73698H4.31641V4.07031H13.6497V2.73698Z" fill="#DC1E52"/></svg></button>
    	                        </div>
    	                    </td>
    	                    <td><p class="table-items">Содержание</p></td>
    	                    <td><p class="table-items nowrap">Статус</p></td>
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
    	                    <td>{{$item->name}}</td>
    	                    <td>
    	                    	<p class="settings-content">
                                    @if (request('type')==4)
                                        @foreach (json_decode($item->value,1) as $k=>$v)
                                            {{ App\Models\Setting::find($k)->name }}
                                            : {{$v}}<br>
                                        @endforeach
                                    @else
                                        {!! $item->value !!}
                                    @endif
                                </p>
                                <div class="settings-links">
                                    <a class="edit" href="{{route('settings.edit', $item->id)}}">Редактировать</a>
                                    <span>|</span>
                                    <button class="delete" type="button" data-id="{{$item->id}}">Удалить</button>
                                </div>
    	                    	</td>
    	                    <td class="nowrap">{{$item->active?'Активно':'Неактивно'}}</td>
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

		    $('button.delete').click(function(){
		    	$('#ch-only-'+$(this).data('id')).prop('checked',true);
		    	$(this).parents('form').submit();
		    });
		});
	</script>
@endsection
