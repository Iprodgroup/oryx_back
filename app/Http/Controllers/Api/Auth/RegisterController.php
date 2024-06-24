<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
        ], [
            'email.unique' => 'Этот адрес почты уже существует'
        ]);
    }

    protected function create(array $data)
    {
        $item = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => preg_replace("/[^0-9]/", '', $data['phone']),
            'tariff_id' => Setting::where(['code' => 'default', 'type' => 4, 'active' => 1])->first()->id,
            'settings' => [
                'regp' => 1,
                'usa' => 1,
                'delivered' => 1,
                'balance' => 1,
                'bonus' => 1,
                'disable' => 0,
            ],
            'id_orx' => 'ORX' . (User::orderBy('id', 'DESC')->first()->id + 1),
        ]);
        $item->syncRoles([Role::where('name', 'users')->first()->id]);
        return $item;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        event(new Registered($user = $this->create($request->all())));
        // Optionally log the user in
        // $this->guard()->login($user);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}
