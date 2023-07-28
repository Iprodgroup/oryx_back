<a href="{{route('admins.edit', Auth::user()->id)}}" class="admin-info">
    <div class="avatar">
    	@if (Auth::user()->getMedia('avatars')->first())
    		<img src="{{ Auth::user()->getMedia('avatars')->first()->getUrl('thumb') }}">
    	@else
    		<img src="{{ asset('admin/images/user.png') }}">
    	@endif
    </div>
    <div class="admin-data">
        <p class="admin-name">{{ Auth::user()->name }}</p>
        <p class="admin-mail">{{ Auth::user()->email }}</p>
    </div>
</a>
