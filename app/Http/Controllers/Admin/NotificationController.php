<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

use Gate;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $items = Setting::where('type',1)->paginate(10);
        return view('admin.notifications.index', compact('items'));
    }

    public function create()
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = new Setting();
        return view('admin.notifications.form', compact('item'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        Setting::create($request->all());

        return redirect()->route('notifications.index');
    }

    public function edit(Setting $item, $id)
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = Setting::findOrFail($id);
        return view('admin.notifications.form', compact('item'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        $item = Setting::findOrFail($id);
        $item->fill($request->all())->save();

        return redirect()->route('notifications.index');
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('notifications'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Setting::whereIn('id',$request->input('id',[]))->delete();
        return redirect()->route('notifications.index');
    }
}
