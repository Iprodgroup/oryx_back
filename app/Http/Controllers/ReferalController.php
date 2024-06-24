<?php

namespace App\Http\Controllers;

use App\Models\Referal;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ReferalController extends Controller
{

    use RedirectsUsers;
    public function referal_register(Request $request, $user_id)
    {
        //dd($user_id);

        if($request->method() === 'POST'){

            $request->validate([
                'email' => 'required|email|max:250|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);

            $item = User::create([
                //'name' => $data['name'],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => preg_replace("/[^0-9]/", '', $request->phone),
                'tariff_id' => Setting::where(['code'=>'default', 'type'=>4, 'active'=>1])->first()->id,
                'settings' => [
                    'regp' => 1,
                    'usa' => 1,
                    'delivered' => 1,
                    'balance' => 1,
                    'bonus' => 1,
                    'disable' => 0,
                ],
                //Integration
                'id_orx' => 'ORX'.(User::orderBy('id', 'DESC')->get()[0]['id'] + 1),
                //
            ]);
            $item->syncRoles([Role::where('name','users')->first()->id]);


            $user_id = $request->only(['user_id']);
            //dd($request, $user_id);

            $referal = new Referal;
            $referal->user_id = $user_id['user_id'];
            $referal->friend_id = $item->id;
            $referal->status = 'регистрирован';
            $referal->save();
            //dd($request, $referal);

            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect('/profile');
        }

        return view('auth.referal-register', ['user_id' => $user_id]);
    }
}
