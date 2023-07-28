<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipient;
use App\Models\User;

class AjaxController extends Controller
{
    public function recipient(Request $request)
    {
        $items = [];
        $term = '%'.$request->input('term').'%';
        foreach (Recipient::where('name','like',$term)->orWhere('fname','like',$term)->orWhere('surname','like',$term)->orWhere('fio','like',$term)->orWhere('user_id','like',$term)->orderBy('fio')->limit(10)->get() as $item) {
            $label = $item->fio?$item->fio:$item->surname.' '.$item->name.' '.$item->fname;
            $label .= ' ('.$item->user->tariffObj->name.') UID'.$item->user_id;
            $items[] = [
                'recipient' => $item->id,
                'user' => $item->user_id,
                'label' => $label,
            ];
        }

    	return response()->json($items);
    }

    public function user(Request $request)
    {
        $items = [];
        $term = '%'.$request->input('term').'%';
        $items_ = User::whereHas('roles', function($q){
                $q->where('name', 'users');
            })->where(function($q) use ($term){
                $q->where('name','like',$term)
                  ->orWhere('fname','like',$term)
                  ->orWhere('surname','like',$term)
                  ->orWhere('fio','like',$term)
                  ->orWhere('id','like',$term)
                  ->orderBy('fio');
            })->limit(10)->get();
        foreach ($items_ as $item) {
            $label = $item->fio?$item->fio:$item->surname.' '.$item->name.' '.$item->fname;
            $label .= ' ('.$item->user->tariffObj->name.') UID'.$item->id;
            $items[] = [
                'user' => $item->id,
                'label' => $label,
            ];
        }

        return response()->json($items);
    }
}
