<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->roles->first()->permissions()->count()) abort(403);
    	$permission = \Auth::user()->roles->first()->permissions()->first()->name;
    	$route = str_replace('public/', '', route($permission.'.index'));
        return redirect($route);
    }

    public function cashback()
    {
    	return view('admin.cashback');
    }
}
