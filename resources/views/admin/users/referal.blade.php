@extends('layouts.admin')
@section('header')
	<div class="header header-users">
	    <div class="inner">
            <a href="/" class="logo"><img src="{{ asset('admin/images/logoadmin.png') }}"></a>
	         <div class="cms">CMS</div>
	    </div>
	    <div class="search">

	    </div>
	</div>
@endsection
@section('content')
	<div class="buttons-top" style="left: 300px;right: auto;">
		<form action="" id="form">
        	с <input type="date" name="start" id="start" value="{{ $start }}">
        	по <input type="date" name="stop" id="stop" value="{{ $stop }}">
        </form>
	</div>
	<div class="buttons-top">
        <form action="">
        	<a class="createuser" href="{{route('users.load',[$id,$start,$stop])}}">Скачать</a>
        </form>
	</div>
	<div class="main-content">
	    <form action="" method="POST">
	    	@csrf
	        <table class="table tablebordered">
	            <thead>
	                <tr>
	                    <td><p class="table-items">Добавлен</p></td>
	                    <td><p class="table-items">Статус</p></td>
	                    <td><p class="table-items">Трек США</p></td>
	                    <td><p class="table-items">Трек сдэк</p></td>
	                    <td><p class="table-items">Вес</p></td>
	                    <td><p class="table-items">UID</p></td>
	                </tr>
	            </thead>
	            <tbody>
	            	@foreach($items as $item)
	                <tr>
	                    <td>{{$item->created_at->format('d.m.Y')}}</td>
	                    <td>{{ __('ui.status')[$item->status] }}</td>
	                    <td>{{$item->track}}</td>
	                    <td>{{$item->in_track}}</td>
	                    <td>{{$item->weight}}</td>
	                    <td>{{$item->user_id}}</td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    </form>
	</div>
	<script>
		$(function(){
			$('#start, #stop').change(function () {
				$('#form').submit();
			});
		});
	</script>
@endsection
