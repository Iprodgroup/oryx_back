<?php

namespace App\Http\Controllers;

use App\Mail\ContactShipped;
use App\Mail\Email;
use App\Mail\OrderShipped;
use App\Models\Category;
use App\Models\Category_Store;
use App\Models\Element;
use App\Models\News;
use App\Models\Question;
use App\Models\Review;
use App\Models\Store;
use App\Services\ShortcodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about () {

        $data = ShortcodeService::doShortcode('o-kompanii');

        return view('pages.about', ['data' => $data]);
    }

    public function popularStores (Request $request) {

        //dd($request->extra_fields);
        if ($request->extra_fields) {
            $selects = $request->extra_fields;
            session()->put('selects', $selects);
            $fields = Category_Store::whereIn('category_id', $selects)->get();
            $fields = collect($fields)->pluck('store_id')->all();
            $stores = Store::whereIn('id', $fields)->where('status', 'active')->paginate(16);
        } else {
            $selects = session()->get('selects') ?? [];
            $fields = Category_Store::whereIn('category_id', $selects)->get();
            $fields = collect($fields)->pluck('store_id')->all();
            $stores = Store::whereIn('id', $fields)->where('status', 'active')->paginate(16);
        }

        $categories = Category::get();

        if ($stores) {

            $data = ShortcodeService::doShortcode('populiarnye');

            return view('pages.popularStores', [
                'stores'        => $stores,
                'categories'    => $categories,
                'selects'       => $selects,
                'data'          => $data
            ]);
        } else return redirect('404');

    }

    public function store ($slug) {
        $store = Store::where('slug', $slug)->first();
        if ($store) {

            $data = ShortcodeService::doShortcode('magazin', ['store-name' => $store->name]);

            return view('pages.product', ['store' => $store, 'data' => $data]);
        } else return redirect('404');
    }

    public function reviews () {
        $reviews = Review::where('status', 'active')->get();

        $data = ShortcodeService::doShortcode('otzyvy');

        return view('pages.reviews', ['reviews' => $reviews, 'data' => $data]);
    }

    public function help () {
        $questions = Question::where('status', 'active')->get();

        $data = ShortcodeService::doShortcode('usloviia');

        return view('pages.help', ['questions' => $questions, 'data' => $data]);
    }

    public function news () {

        $news = News::where('status', 'active')->get();

        $data = ShortcodeService::doShortcode('poleznoe');

        return view('pages.news', ['data' => $data, 'news'  => $news]);
    }
    public function newsPage($slug) {

        $new = News::where('slug', $slug)->first();

        $data = ShortcodeService::doShortcode('novost', [
            'new-name' => $new->name,
            'new-description' => $new->description,
            'new-img' => $new->img,
            'new-title' => $new->title,
            'new-meta-desc' => $new->meta_desc
        ]);

        return view('pages.news-page', ['new' => $new, 'data' => $data]);
    }

    public function zapreshenye () {

        $data = ShortcodeService::doShortcode('zapreshheny');

        return view('pages.zapreshenye', ['data' => $data]);
    }


    public function contactsUs () {
        $contacts = Element::where('type', 'kontakty')->get();

        $data = ShortcodeService::doShortcode('kontakty');

        return view('pages.contactUs', ['contacts' => $contacts, 'data' => $data]);
    }


    public function politika () {

        $rekvisit = Element::where('type', 'rekvisit')->get();

        $data = ShortcodeService::doShortcode('politika');

        return view('pages.politika', ['rekvisit' => $rekvisit, 'data' => $data]);
    }


    public function usloviya () {

        $data = ShortcodeService::doShortcode('o-usloviia');

        return view('pages.usloviya', ['data' => $data]);
    }


    public function buy_me () {

        $data = ShortcodeService::doShortcode('kupite');

        return view('pages.buy-me', ['data' => $data]);
    }

    //public function buy () {return view('pages.buy-me');}

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

        Mail::to('ofis@orix.kz')->send(new OrderShipped($purchase));

        return redirect()->back()->with('status', 'success');
    }

    public function email(Request $request) {

        $email = Arr::get($request, 'email');
        $name = Arr::get($request, 'name');


        if ($email) {
            Mail::to('ofis@orix.kz')->send(new Email($email, $name));
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
