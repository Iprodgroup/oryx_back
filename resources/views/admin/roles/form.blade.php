<div class="roles">
	<input type="hidden" class="item-id" name="id[]" value="{{$item->id}}">
    <div class="nameflex">
        <div class="role-1">Роль <span class="title-index">{{isset($index)?$index+1:1}}</span></div>
        <div class="del-button">
            <button type="submit" class="dels">Удалить <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.42578 1.52344L12.9258 13.0234" stroke="#DC1E52" stroke-width="3"/><path d="M12.9258 1.52344L1.42578 13.0234" stroke="#DC1E52" stroke-width="3"/></svg>
            </button>
        </div>
    </div>
    <div class="role-inputs">
        <div class="first-inputs">
            <p class="in-names">Название</p>
            <input type="text" name="title[]" value="{{$item->title}}" class="role-input"/>
        </div>
    </div>
    <div class="dostup">
        <div class="role-1">Назначить доступ</div>
        <div class="selectors">
            <p class="in-names">Разделы</p>
            <div class="select-input">
                <div class="selects-one">
                    <div class="examples">Назначить доступные разделы</div>
                    <div class="input-groups">
                        <input type="checkbox" name="check-all" class="checks check-all">
                        <div class="toggle-button"><svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 9L10.2631 0.75H0.73686L5.5 9Z" fill="#333333"/></svg></div>
                    </div>
                </div>
	            <div class="others-inputs">
	            	@foreach($permissions as $id=>$title)
			            <div class="others-flex">
	                    	<div class="razdel">{{$title}}</div>
	                       	<input type="checkbox" name="permission{{isset($index)?$index:0}}[]" class="checks" value="{{$id}}" 
	                       	@if($item->id)
				              {{$item->permissions->contains($id)? 'checked' : ''}}
				            @endif>
	                 	</div>
			        @endforeach
	            </div>
            </div>
        </div>
    </div>
</div>