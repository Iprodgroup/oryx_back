<?php

namespace App\Http\Controllers;

use App\Mail\ContactShipped;
use App\Mail\Email;
use App\Mail\OrderShipped;
use App\Models\Category;
use App\Models\Category_Store;
use App\Models\Element;
use App\Models\Question;
use App\Models\Review;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about () {return view('pages.about');}
    public function popularStores (Request $request) {

        if ($request->extra_fields) {
            $selects = $request->extra_fields;
            $fields = Category_Store::whereIn('category_id', $selects)->get();
            $fields = collect($fields)->pluck('store_id')->all();
            $stores = Store::whereIn('id', $fields)->where('status', 'active')->inRandomOrder()->paginate(16);
        } else {$stores = Store::where('status', 'active')->inRandomOrder()->paginate(16); $selects = [];}

        $categories = Category::get();

        if ($stores) {
            return view('pages.popularStores', ['stores' => $stores, 'categories' => $categories, 'selects' => $selects]);
        } else return redirect('404');

    }

    public function product ($slug) {
        $store = Store::where('slug', $slug)->first();
        if ($store) {
            return view('pages.product', ['store' => $store]);
        } else return redirect('404');
    }

    public function reviews () {
        $reviews = Review::where('status', 'active')->get();

        return view('pages.reviews', ['reviews' => $reviews]);
    }

    public function help () {
        $questions = Question::where('status', 'active')->get();

        return view('pages.help', ['questions' => $questions]);
    }

    public function news () {return view('pages.news');}

    public function zapreshenye () {return view('pages.zapreshenye');}

    public function contactsUs () {
        $contacts = Element::where('type', 'kontakty')->get();

        return view('pages.contactUs', ['contacts' => $contacts]);
    }

    public function politika () {return view('pages.politika');}

    public function usloviya () {return view('pages.usloviya');}


    public function buy_me () {return view('pages.buy-me');}

    public function buy () {return view('pages.buy-me');}

    public function send(Request $request)
    {
        $orders = Arr::get($request, 'tblAppendGrid_rowOrder', 0);
        $orders = explode(',', $orders);

        $nomer = Arr::get($request, 'number', 0);

        $products = [];

        foreach ($orders as $key => $order) {
            $link = Arr::get($request, "tblAppendGrid_link_$order");
            $name = Arr::get($request, "tblAppendGrid_product-name_$order");
            $info = Arr::get($request, "tblAppendGrid_product-info_$order");

            if ($link && $name) {
                $products[$key]['product-link'] = $link;
                $products[$key]['product-name'] = $name;
                $products[$key]['product-info'] = $info;
            }
        }

        $purchase = ['nomer' => $nomer, 'products' => $products];

        Mail::to('fatullayevbexruz011@gmail.com')->send(new OrderShipped($purchase));

        return redirect()->back()->with('status', 'success');
    }

    public function email(Request $request) {

        $email = Arr::get($request, 'email');


        if ($email) {
            Mail::to('fatullayevbexruz011@gmail.com')->send(new Email($email));
        }

        return redirect()->back()->with('status', 'success');
    }

    public function review(Request $request) {


        $name = Arr::get($request, 'name');
        $review = Arr::get($request, 'review');

        $test = Review::first();

        //dd($test);

        $new_review =  new Review;

        $new_review->name = $name;
        $new_review->message = $review;
        $new_review->status = 'disabled';
        $new_review->save();

        /*if ($name && $review) {
            Mail::to('fatullayevbexruz011@gmail.com')->send(new \App\Mail\Review($review, $name));
        }*/

        return redirect()->back()->with('status', 'success');
    }
}
