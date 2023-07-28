<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;

use Spatie\Permission\Models\Role;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        //dd(Auth::check(), Gate::denies('admins'));
        if (Auth::check()) {
            if (Gate::denies('admins')) {
                return redirect('/');
            } else {
                abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
                $items = User::whereHas('roles', function($q){
                    $q->where('name', '!=', 'users');
                })->paginate(999);
                // $items = User::paginate(10);
                return view('admin.admins.index', compact('items'));
            }
        } else {
            abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function create()
    {
        abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::where('name','!=','users')->orderBy('title')->pluck('title', 'id');
        $item = new User();

        $cities = [''=>''];
        foreach (Setting::where([['type',2],['active',1]])->get() as $country) {
            foreach (explode("\r\n", $country->value) as $value) {
                $cities[$value] = $value;
            }
        }
        return view('admin.admins.form', compact('item','roles','cities'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
            'email' =>  'required|max:190',
            'password' =>  'required|max:190'
        ]);

        $fill = $request->except(['role','avatar']);

        if(!$fill['password'])  unset($fill['password']);
        else $fill['password'] = Hash::make($fill['password']);

        $item = User::create($fill);
        $item->syncRoles([$request->input('role',0)]);

        if ($request->file('avatar')) {
            $item->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('admins.index');
    }

    public function edit(User $item, $id)
    {
        abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = User::findOrFail($id);
        $roles = Role::where('name','!=','users')->orderBy('title')->pluck('title', 'id');
        $cities = [''=>''];
        foreach (Setting::where([['type',2],['active',1]])->get() as $country) {
            foreach (explode("\r\n", $country->value) as $value) {
                $cities[$value] = $value;
            }
        }
        return view('admin.admins.form', compact('item','roles','cities'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
            'email' =>  'required|max:190'
        ]);

        $item = User::findOrFail($id);

        $fill = $request->except(['role','avatar']);

        if(!$fill['password'])  unset($fill['password']);
        else $fill['password'] = Hash::make($fill['password']);
        $item->fill($fill)->save();
        $item->syncRoles([$request->input('role',0)]);

        if ($request->file('avatar')) {
            $mediaItem = $item->getMedia('avatars')->first();
            if($mediaItem) $mediaItem->delete();
            $item->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('admins.index');
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('admins'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::whereIn('id',$request->input('id',[]))->delete();
        return redirect()->route('admins.index');
    }
}
