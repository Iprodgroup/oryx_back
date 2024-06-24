<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instead;
use Mail;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class InsteadController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $items = Instead::when(request('status'),function($q){
            $q->where('status',request('status')-1);
        })->orderBy('id','desc')->paginate(10);
        return view('admin.instead.index', compact('items'));
    }

    public function create()
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = new Instead();
        $recipients = [];
        foreach (User::all() as $recipient) {
            $recipients[$recipient->id] = $recipient->fname.' '.$recipient->name.' '.$recipient->surname;
        }
        return view('admin.instead.form', compact('item','recipients'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        Instead::create($request->all());

        return redirect()->route('instead.index');
    }

    public function edit(Instead $item, $id)
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = Instead::findOrFail($id);
        $recipients = [];
        foreach (User::all() as $recipient) {
            $recipients[$recipient->id] = $recipient->fname.' '.$recipient->name.' '.$recipient->surname;
        }
        return view('admin.instead.form', compact('item','recipients'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        $item = Instead::findOrFail($id);
        $old = $item->status;
        $item->fill($request->all())->save();

        if($old != $item->status){
            Mail::send(
                'emails.notification',
                ['text' => "Статус вашей заявки по товару ".$item->name." "
                    .__('ui.istatus.'.$item->status)],
                function ($m) use ($item) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $m->to($item->user->email, $item->user->name)->subject('Помощь при покупке');
            });
        }

        return redirect()->route('instead.index');
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('instead'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Instead::whereIn('id',$request->input('id',[]))->delete();
        return redirect()->route('instead.index');
    }
}
