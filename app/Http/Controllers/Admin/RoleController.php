<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Gate;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(Request $request)
    {
    	// abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    	if($request->method() == 'POST'){
    		$items = $request->all();
    		if(isset($items['id'])){
    			for ($i=0; $i < count($items['id']); $i++) { 
    				if($items['id'][$i]){
    					$item = Role::findOrFail($items['id'][$i]);
    					$item->fill(['title'=>$items['title'][$i]])->save();
    				}else{
    					$item = Role::create(['name'=>'role'.time(),'title'=>$items['title'][$i]]);
    				}
    				if(isset($items['permission'.$i])){
						$item->syncPermissions($items['permission'.$i]);
					}
    			}
    		}
    		if(isset($items['delete'])){
    			Role::whereIn('id', $items['delete'])->delete();
    		}
    		return redirect()->route('roles.index');
    	}
    	$role = new Role;
    	$items = Role::where('name','!=','users')->get();
    	$permissions = Permission::orderBy('title')->pluck('title', 'id');
        return view('admin.roles.index', compact('role','items','permissions'));
    }
}
