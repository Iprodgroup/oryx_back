@extends('layouts.admin')
@section('content')
    <div class="buttons-top" style="left: 300px;right: auto;">
        <form action="" id="status">
            {{ Form::select('status', array_merge(['Все статусы'], __('ui.istatus')), request('status')) }}
        </form>
    </div>
	<div class="buttons-top">
        <form action="">
        	<a class="createuser" href="{{route('instead.create')}}">Добавить +</a>
        </form>
	</div>
	<div class="main-content">
	    <form action="{{route('instead.delete')}}" method="POST">
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
	                    <td><p class="table-items">Получатель</p></td>
	                    <td><p class="table-items">ID</p></td>
	                    <td><p class="table-items">Дата</p></td>
	                    <td><p class="table-items">Статус</p></td>
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
	                    	<p class="instead-content">{{ $item->user->fname ?? '' }} {{ $item->user->name ?? '' }} {{ $item->user->surname ?? '' }}</p>
	                          <div class="instead-links">
	                              <a class="edit" href="{{route('instead.edit', $item->id)}}">Редактировать</a>
	                              <span>|</span>
	                              <button class="delete" type="button" data-id="{{$item->id}}">Удалить</button>
	                          </div>
	                    	</td>
	                    <td>{{ $item->user->id ?? '' }}</td>
	                    <td>{{ $item->created_at->format('d.m.Y') }}</td>
                        <td>{{ __('ui.istatus.'.$item->status) }}</td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    </form>
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

		    $('button.delete').click(function(){
		    	$('#ch-only-'+$(this).data('id')).prop('checked',true);
		    	$(this).parents('form').submit();
		    });
		});
	</script>
@endsection
