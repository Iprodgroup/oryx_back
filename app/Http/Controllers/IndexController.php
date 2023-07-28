<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $reviews = Review::where('status', 'active')->get();
        $questions = Question::where('status', 'active')->get();
        $products = Product::where('status', 'active')->inRandomOrder()->take(8)->get();

        //dd($reviews);
        return view('home', ['reviews' => $reviews, 'questions' => $questions, 'products' => $products]);
    }

    public function notif()
    {
        return view('auth.verify');
    }

    public function confirm(Request $request)
    {
    	if($request->method() === 'POST'){

    		$item = Auth::user();
            $fill = $request->only(['name', 'fname', 'surname', 'email', 'phone']);
            if(isset($fill['phone']))
                $fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);
    		$item->fill($fill);
    		$item->save();

    		return redirect()->route('register.completed');
    	}
        $item = Auth::user();
        return view('auth.confirm', compact('item'));
    }

    public function completed(Request $request)
    {
        return view('auth.completed');
    }

    public function login(Request $request)
    {
    	if (Auth::check()) {
    		return redirect()->route('admin.index');
    	}
        return view('auth.admin-login');
    }
}
