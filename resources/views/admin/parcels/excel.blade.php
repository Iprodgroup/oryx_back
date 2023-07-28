@extends('layouts.admin')
@section('content')

	<div class="content-wrap"> 
	
    	<div class="content">
    	    
    	    
    	    <div class="content-top">
                <div class="content-head_wrap">
                    <div class="content-head">
            	        Загрузить EXCEL
            	    </div>
            	    
            	    <div class="content-text">
            	        Загрузить посылки из excel документа и объеденить с текущей базой посылок
            	    </div>
                </div>
        	    <div class="buttons-top">
                    <form action="" id="city">
                        <input type="hidden" name="s" value="">
                        <div style="display: inline-block">
                            <label>c <input type="date" name="ds" value=""></label>
                            <label>по <input type="date" name="de" value=""></label>
                        </div>
                    </form>
                </div>
                <div class="buttons-top">
                    <a class="go-back" href="{{route('parcels.index')}}">Назад <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.734375 7.99988L9.49987 15.6697V11.2264C12.258 10.9323 14.5383 11.7168 16.4106 13.5891L17.8332 15.0117V12.9999C17.8332 7.7786 14.9571 4.94273 9.49987 4.68574V0.330078L0.734375 7.99988ZM3.26537 7.9999L7.83322 4.00304V6.33323H8.66655C13.0004 6.33323 15.3753 7.87575 15.9988 11.097C13.8795 9.67865 11.375 9.20365 8.52955 9.6779L7.83322 9.79396V11.9968L3.26537 7.9999Z" fill="white"/></svg></a>
            	</div>
            </div> 
    	    
    	    
    	    <div class="matched">
    	    	@foreach (['Совпавшие посылки','Частичное совпадение','Не совпавшие посылки'] as $key=>$name)
    	    		<a class="{{ request()->input('t',0)==$key? 'active' : '' }}" href="{{route('parcels.excel',['id'=>$id,'t'=>$key])}}">{{ $name }} ({{ count(${'items'.$key}) }})</a>
    	    	@endforeach
    	    </div>
    	    <form action="{{route('parcels.replaces',$id)}}" method="POST">
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
    	                            <button type="submit" class="del">Обновить</button>
    	                        </div>
    	                    </td>
    	                    <td><p class="table-items">Трек номер</p></td>
    	                    <td><p class="table-items">Получатель</p></td>
    	                </tr>
    	            </thead>
    	            <tbody>
    	            	@foreach(${'items'.request()->input('t',0)} as $item)
    	                <tr>
    	                    <td class="checks">
    	                        <div class="default-checkbox">
    	                            <input type="checkbox" class="custom-control-input checkbox" id="ch-only-{{$item->id}}" name="id[]" value="{{$item->id}}">
    	                            <label class="custom-control-label" for="ch-only-{{$item->id}}"></label>
    	                        </div>
    	                    </td>
    	                    <td>#{{$item->id}}</td>
    	                    <td>
    	                    	@if ($t==1)
    	                    		<div class="t-group">
    		                            <p class="track">{{ $item->track }} <span>(частичное совпадение)</span></p>
    		                            <div class="yellow-track">
    		                            	@foreach ($tracks_full as $key=>$track)
    		                            		@if (strpos((string)$item->track, (string)$tracks6[$key]) !== false)
                                                    <input type="hidden" name="r[{{$item->id}}]" value="{{$track[0]}}">
                                                    @if ($item->id)
                                                        <input type="hidden" name="status[{{$item->id}}]" value="{{$track[4]}}">
                                                        <input type="hidden" name="p[{{$item->id}}]" value="{{$track[1]}}">
                                                        <input type="hidden" name="w[{{$item->id}}]" value="{{$track[2]}}">
                                                        <input type="hidden" name="d[{{$item->id}}]" value="{{$track[3]}}">
                                                        <input type="hidden" name="it[{{$item->id}}]" value="{{$track[5]}}">
                                                    @endif
    		                            			<p class="yellow">{{ $track[0] }}</p>
    		                            			<a href="{{route('parcels.replace',[
                                                        'id'=>$id,
                                                        'pid'=>$item->id,
                                                        'status'=>$track[4],
                                                        'r'=>$track[0],
                                                        'p'=>$track[1],
                                                        'w'=>$track[2],
                                                        'd'=>$track[3],
                                                        'it'=>$track[5]
                                                        ])}}" class="ex-buttons">Заменить</a>
    		                            			|
    		                            			@if (__('ui.status')[$item->status] == $track[4])
    		                            				Обновлен
    		                            			@else
    		                            				<a href="{{route('parcels.replace',[
                                                            'id'=>$id,
                                                            'pid'=>$item->id,
                                                            'status'=>$track[4],
                                                            'p'=>$track[1],
                                                            'w'=>$track[2],
                                                            'd'=>$track[3],
                                                            'it'=>$track[5]
                                                            ])}}" class="ex-buttons">Обновить статус</a>
    		                            				&nbsp; {{ __('ui.status')[$item->status] }} -> {{ $track[4] }}
    		                            			@endif
    		                            		@endif
    		                            	@endforeach
    		                            </div>
    		                        </div>
    		                    @elseif($t==2)
    		                    	<div class="t-group">
    		                            <p class="track">{{ $item->track }} <span>(отсутствует)</span></p>
    		                            <p class="track"><a href="{{ route('parcels.create',['t'=>$item->track]) }}" class="ex-buttons" target="_blank">Создать</a></p>
    		                        </div>
    	                    	@else
    	                    		{{-- $item->track --}}
    	                    		<div class="t-group">
    		                            <p class="track">{{ $item->track }} <span>(полное совпадение)</span></p>
    		                            <div class="yellow-track">
    		                            	@foreach ($tracks_full as $track)
    		                            		@if (strpos((string)$item->track, (string)$track[0]) !== false)
                                                    @if ($item->id)
                                                        <input type="hidden" name="status[{{$item->id}}]" value="{{$track[4]}}">
                                                        <input type="hidden" name="p[{{$item->id}}]" value="{{$track[1]}}">
                                                        <input type="hidden" name="w[{{$item->id}}]" value="{{$track[2]}}">
                                                        <input type="hidden" name="d[{{$item->id}}]" value="{{$track[3]}}">
                                                        <input type="hidden" name="it[{{$item->id}}]" value="{{$track[5]}}">
                                                    @endif
    		                            			@if (__('ui.status')[$item->status] == $track[4])
    		                            				Обновлен
    		                            			@else
    		                            			<a href="{{route('parcels.replace',[
                                                        'id'=>$id,
                                                        'pid'=>$item->id,
                                                        'status'=>$track[4],
                                                        'p'=>$track[1],
                                                        'w'=>$track[2],
                                                        'd'=>$track[3],
                                                        'it'=>$track[5]
                                                        ])}}" class="ex-buttons">Обновить статус</a>
    		                            			&nbsp; {{ __('ui.status')[$item->status] }} -> {{ $track[4] }}
    		                            			@endif
    		                            		@endif
    		                            	@endforeach
    		                            </div>
    		                        </div>
    	                    	@endif
    	                    </td>
    	                    <td>{{ $item->recipient->surname ?? '' }} {{ $item->recipient->name ?? '' }} {{ $item->recipient->fname ?? '' }}</td>
    	                </tr>
    	                @endforeach
    	            </tbody>
    	        </table>
    	    </form>
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

		    $('.buttons-top3 a').click(function(e){
		    	e.preventDefault();
		    	$(this).next().click();
		    });

		    $(".buttons-top3 [name=file]").change(function () {
			    $(this).next().click();
			});
		});
	</script>
@endsection

