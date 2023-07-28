<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function __construct(Socialite $socialite){
    	$this->socialite = $socialite;
   	}


	public function getSocialAuth($provider=null)
	{
		if(!config("services.$provider")) abort('404');
		return $this->socialite->with($provider)->scopes(['email'])->redirect();
	}

	public function getSocialAuthCallback($provider=null)
	{
		if($user = $this->socialite->with($provider)->user()){
			$item = User::where('email',$user->email)->orWhere('social_id',$user->id)->first();
			if ($item) {
				Auth::login($item, true);
			} else {
				$name = explode(' ', $user->name);

				$item = User::create([
		            'email_verified_at' => Carbon::now(),
		            'email' => $user->email,
		            'social_id' => $user->id,
		            'password' => Hash::make(Str::random(20)),
		            'name' => $name[0],
		            'surname' => isset($name[1])?$name[1]:'',
                    'tariff_id' => Setting::where(['code'=>'default', 'type'=>4, 'active'=>1])->first()->id,
		        ]);

		        $item->syncRoles([Role::where('name','users')->first()->id]);
		        Auth::login($item, true);
			}

			return redirect()->route('profile.index');

			//dd($user);
		}else{
			return 'something went wrong';
		}
	}
}
