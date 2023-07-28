<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

use Gate;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    private $forms = ['form','form','country','country_out','tariff'];

    public function index(Request $request)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $type = $request->input('type',0);
        $items = Setting::where('type',$type)->paginate(30);
        return view('admin.settings.index', compact('items','type'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $type = $request->input('type',0);
        $item = new Setting();
        return view('admin.settings.'.$this->forms[$type], compact('item'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        $fill = $request->all();
        if($fill['type']==3)
            $fill['value'] = implode('/', $fill['value']);
        if($fill['type']==4)
            $fill['value'] = json_encode($fill['value']);

        Setting::create($fill);

        return redirect()->route('settings.index', ['type'=>$fill['type'] ?? 0]);
    }

    public function edit(Setting $item, $id)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = Setting::findOrFail($id);
        if($item->type==3)
            $item->value = explode('/', $item->value);
        return view('admin.settings.'.$this->forms[$item->type], compact('item'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
        ]);

        $item = Setting::findOrFail($id);
        $fill = $request->all();
        if($fill['type']==3)
            $fill['value'] = implode('/', $fill['value']);
        if($fill['type']==4)
            $fill['value'] = json_encode($fill['value']);
        $item->update($fill);

        return redirect()->route('settings.index', ['type'=>$fill['type'] ?? 0]);
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('settings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(count($request->input('id',[])))
            Setting::whereIn('id',$request->input('id'))->delete();
        return redirect()->route('settings.index');
    }
}
