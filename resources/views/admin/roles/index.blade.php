@extends('layouts.admin')
@section('content')
	<form id="form-role" action="" method="POST">
		@csrf
		
		
		<div class="content-wrap">
		    
		    <div class="content-top">
		        
		        <div class="buttons-top2">
        	        <a class="go-back" href="{{route('admins.index')}}">Вернуться назад <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.734375 7.99988L9.49987 15.6697V11.2264C12.258 10.9323 14.5383 11.7168 16.4106 13.5891L17.8332 15.0117V12.9999C17.8332 7.7786 14.9571 4.94273 9.49987 4.68574V0.330078L0.734375 7.99988ZM3.26537 7.9999L7.83322 4.00304V6.33323H8.66655C13.0004 6.33323 15.3753 7.87575 15.9988 11.097C13.8795 9.67865 11.375 9.20365 8.52955 9.6779L7.83322 9.79396V11.9968L3.26537 7.9999Z" fill="white"/></svg></a>
        	    </div>
		        
		    </div>
		    
		    <div class="content">
		        
		        <div class="main-content">
        	    	@if(count($items))
        		        @foreach($items as $index=>$item)
        		          @include('admin.roles.form',['item'=>$item,'index'=>$index])
        		        @endforeach
        		    @else
        		        @include('admin.roles.form',['item'=>$role])
        		    @endif
        
        		    <div id="new-roles"></div>
        	        
        	        
        	        <div class="add-role">
        	            <button type="button" class="add">Добавить роль <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.13086 5.51367H13.46V9.18262H9.13086V14.1465H5.13184V9.18262H0.790039V5.51367H5.13184V0.689453H9.13086V5.51367Z" fill="#DC1E52"/></svg></button>
        	        </div>
        
        	        <div class="buttons-group">
        	            <a href="{{route('admins.index')}}">Отменить изменения <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.277344 7.03233L8.09108 13.8694V9.90854C10.5498 9.64637 12.5824 10.3457 14.2515 12.0147L15.5196 13.2828V11.4894C15.5196 6.83507 12.9558 4.30712 8.09108 4.07803V0.195312L0.277344 7.03233ZM2.53471 7.03278L6.60657 3.4699V5.54708H7.34942C11.2127 5.54708 13.3297 6.92211 13.8856 9.79361C11.9964 8.52925 9.76382 8.10583 7.2273 8.52859L6.60657 8.63204V10.5957L2.53471 7.03278Z" fill="#515151"/></svg>
        	            </a>        
        	            <button type="submit">Сохранить изменения <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.67902 0.46875H11.4909L13.9249 2.97016V12.7147C13.9249 13.4661 13.3157 14.0753 12.5643 14.0753H1.67902C0.927546 14.0753 0.318359 13.4661 0.318359 12.7147V1.82941C0.318359 1.07794 0.927546 0.46875 1.67902 0.46875ZM10.5233 1.83011V5.91208H3.72002V1.83011H1.67904V12.7154H3.03969V7.27274H11.2036V12.7154H12.5643V3.52362L10.9164 1.83011H10.5233ZM5.07843 4.55142V1.83011H9.1604V4.55142H5.07843ZM4.40039 8.63349V12.7155H9.84302V8.63349H4.40039ZM8.4824 2.51045H7.12174V3.8711H8.4824V2.51045Z" fill="white"/></svg>
        	            </button>
        	        </div>
        	    </div>
		        
		    </div>
		    
		</div>
		
	    
	    
	</form>
	<div style="display: none;" id="template">@include('admin.roles.form',['item'=>$role])</div>
	<script>
	    $(".select-input .selects-one").on("click",function(){
	        $(this).next().slideToggle();
	    });

	    $(function(){
	    	$('.add-role .add').click(function (e) {
		      e.preventDefault();
		      var $clone = $('#template .roles').clone();
		      var index = $('#form-role .roles').length;
		      $clone.find('.title-index').html(index+1);
		      $clone.find('.others-inputs input[type=checkbox]').attr('name','permission'+index+'[]');
		      $clone.appendTo('#new-roles');

		      $clone.find(".select-input .selects-one").on("click",function(){$(this).next().slideToggle();	    });
		    });

		    $('#form-role').on('click','.dels',function (e) {
		      e.preventDefault();
		      var $item = $(this).parents('.roles');
		      if($item.find('.item-id').val())  
		        $('#form-role').append('<input type="hidden" name="delete[]" value="'+$item.find('.item-id').val()+'">');
		      $item.remove();
		      if($('#form-role .roles').length){
		        $('#form-role .roles').each(function(i,o){
		          $(o).find('.title-index').html(i+1);
		          $(o).find('.others-inputs input[type=checkbox]').attr('name','permission'+i+'[]');
		        });
		      }
		    });

		    $('#form-role').on('change','.check-all',function () {
		      if($(this).is(':checked')){
		        $(this).parents('.select-input').find('input[type=checkbox]').prop('checked',true);
		      }else{
		        $(this).parents('.select-input').find('input[type=checkbox]').prop('checked',false);
		      }
		    });
	    });
	</script>
@endsection