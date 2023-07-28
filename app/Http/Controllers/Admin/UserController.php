<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parcel;

use Spatie\Permission\Models\Role;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $items = User::whereHas('roles', function($q){
		    $q->where('name', 'users');
		});
		if($request->input('s','')){
            $items->where(function($q) use ($request){
                $q->where('id', 'like', "%".$request->input('s')."%")
                    ->orWhere('email', 'like', "%".$request->input('s')."%");
            });
        }
        if($request->input('status')){
            $items->where('tariff_id', $request->input('status'));
        }
		$items = $items->orderBy('id','desc')->paginate(50);
        return view('admin.users.index', compact('items'));
    }

    public function create()
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = new User();
        return view('admin.users.form', compact('item'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
            'email' =>  'required|max:190',
            'password' =>  'required|max:190'
        ]);

        $fill = $request->except(['role','avatar']);

        if(!$fill['password'])  unset($fill['password']);
        else $fill['password'] = Hash::make($fill['password']);
        $fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);

        $item = User::create($fill);
        $item->syncRoles([Role::where('name','users')->first()->id]);

        if ($request->file('avatar')) {
            $item->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.index');
    }

    public function edit(User $item, $id)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = User::findOrFail($id);
        return view('admin.users.form', compact('item'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name'   =>  'required|max:190',
            'email' =>  'required|max:190'
        ]);

        $item = User::findOrFail($id);

        $fill = $request->except(['role','avatar']);

        if(!$fill['password'])  unset($fill['password']);
        else $fill['password'] = Hash::make($fill['password']);
        $fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);
        $item->fill($fill)->save();

        if ($request->file('avatar')) {
            $mediaItem = $item->getMedia('avatars')->first();
            if($mediaItem) $mediaItem->delete();
            $item->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return redirect()->route('users.index');
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        User::whereIn('id',$request->input('id',[]))->delete();
        return redirect()->route('users.index');
    }

    public function referal(Request $request, $id)
    {
        abort_if(Gate::denies('users'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!$id) abort(404);
        $start = $request->input('start', Carbon::now()->subMonth(1)->format('Y-m-d'));
        $stop = $request->input('stop', Carbon::now()->format('Y-m-d'));
        $items = Parcel::whereHas('user', function($q) use ($id){
            $q->where('ref_id', $id);
        })->whereBetween('created_at', [$start, $stop])->orderBy('created_at','desc')->get();
        return view('admin.users.referal', compact('items','id','start','stop'));
    }

    public function load($id = 0, $start, $stop)
    {
        $items = Parcel::whereHas('user', function($q) use ($id){
            $q->where('ref_id', $id);
        })->whereBetween('created_at', [$start, $stop])->orderBy('created_at','desc')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $sheet->setCellValue('A1', 'Добавлен');
        $sheet->setCellValue('B1', 'Статус');
        $sheet->setCellValue('C1', 'Трек США');
        $sheet->setCellValue('D1', 'Трек сдэк');
        $sheet->setCellValue('E1', 'Вес');
        $sheet->setCellValue('F1', 'UID');

        $i = 2;

        foreach ($items as $item) {
            $sheet->setCellValue('A'.$i, $item->created_at->format('d.m.Y'));
            $sheet->setCellValue('B'.$i, __('ui.status')[$item->status]);

            $spreadsheet->getActiveSheet()->getCell('C'.$i)->setValueExplicit($item->track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()->getCell('D'.$i)->setValueExplicit($item->track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue('E'.$i, $item->weight);
            $sheet->setCellValue('F'.$i, $item->user_id);

            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public').'/ref'.$id.'.xlsx');
        return response()->download(storage_path('app/public').'/ref'.$id.'.xlsx');
    }
}
