<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipient;
use App\Models\Parcel;
use App\Models\Excel;
use App\Models\ParcelGood;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

use Gate;
use Symfony\Component\HttpFoundation\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Facades\Auth;

class IndController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ind'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Parcel::where('country_out',$request->input('out',6))
        ->when(request('city'), function($q){
            $q->where('city', request('city'));
        })->when(request('in_status'), function($q){
            $q->where('in_status', request('in_status')-1);
        })->when(request('in_city','Нур-Султан'), function($q){
            if(request('in_city')==1)
                $q->whereNotIn('in_city', ['Нур-Султан','Алматы']);
            else
                $q->where('in_city', request('in_city','Нур-Султан'));
        })->when(Auth::user()->city, function($q){
            $q->where('city', Auth::user()->city);
        })->when(request('s'), function($q){
            $q->where('user_id', request('s'))->orWhere('track', 'like', '%'.request('s').'%');
        });

        $count_ = clone $items;

		$items = $items->where('status', 4)->orderBy('id','desc')->paginate(50);
        $count_ = $count_->select(DB::raw('count(*) as c,status'))->groupBy('status')->get();
		$count = [];
		foreach ($count_ as $p) {
			$count[$p->status] = $p->c;
		}
        return view('admin.ind.index', compact('items','count'));
    }

    public function edit(Parcel $item, $id)
    {
        abort_if(Gate::denies('ind'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = Parcel::findOrFail($id);
        $users = Recipient::pluck('name','id');
        return view('admin.ind.form', compact('item','users'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('ind'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'track'         =>  'required|max:190',
            'recipient_id'  =>  'required|exists:recipients,id',
        ]);

        $item = Parcel::findOrFail($id);
        if($request->status==10 && !$item->payed)
            $item->fill($request->except('status'))->save();
        else
            $item->fill($request->all())->save();
        $item->user_id = $item->recipient->user_id;
        $item->save();

        $item->prod_price = $item->weight*$item->user->tariff[$item->country_out];
        $item->save();

        return redirect()->route('ind.index');
    }

    public function load(Request $request)
    {
        $items = Parcel::where('status', 4)->where('country_out',$request->input('out',6))->when(request('city'), function($q){
            $q->where('city', request('city'));
        })->when(request('in_city'), function($q){
            if(request('in_city')==1)
                $q->whereNotIn('in_city', ['Нур-Султан','Алматы']);
            else
                $q->where('in_city', request('in_city'));
        })->when(request('in_status'), function($q){
            $q->where('in_status', request('in_status')-1);
        })->when(Auth::user()->city, function($q){
            $q->where('city', Auth::user()->city);
        })->when(request('s'), function($q){
            $q->where('user_id', request('s'))->orWhere('track', 'like', '%'.request('s').'%');
        })->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = ['UID','Трек','Номер посылки','Трек по стране','ФИО получателя','Город','Адрес','Телефон','Вес','Комментарий','Оплата'];

        foreach ($header as $key => $title) {
            $spreadsheet->getActiveSheet()->getColumnDimension(chr(ord('A')+$key))->setAutoSize(true);
            $sheet->setCellValue(chr(ord('A')+$key).'1', $title);
        }

        $i = 2;

        foreach ($items as $item) {
            $c = 'A';
            $sheet->setCellValue($c++.$i, $item->user_id);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->pid,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->in_track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue($c++.$i, $item->in_fio);
            $sheet->setCellValue($c++.$i, $item->in_city);
            $sheet->setCellValue($c++.$i, $item->in_address);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->in_phone,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue($c++.$i, $item->weight);
            $sheet->setCellValue($c++.$i, $item->in_comment);
            $sheet->setCellValue($c++.$i, $item->payed?'Оплачена':'Не оплачена ');

            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="list.xlsx"');
        $writer->save('php://output');
    }

    public function finance(Request $request)
    {
        abort_if(Gate::denies('finance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Parcel::when(request('out'), function($q){
            $q->where('country_out', request('out'));
        })->when(request('ds'), function($q){
            $q->whereHas('transaction', function($q){
                $q->where('created_at', '>=', request('ds'));
            });
        })->when(request('de'), function($q){
            $q->whereHas('transaction', function($q){
                $q->where('created_at', '<=', request('de').' 23:59');
            });
        })->when(request('s'), function($q){
            $q->where(function($q){
                $q->where('user_id', request('s'))->orWhere('track', 'like', '%'.request('s').'%');
            });
        })->orderBy('id','desc')->paginate(999);

        if(request('load'))
            return $this->f_load($items);

        return view('admin.ind.finance', compact('items'));
    }

    private function f_load($items)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = ['UID','Баланс','Трек','Номер посылки','Дата','Сумма'];

        foreach ($header as $key => $title) {
            $spreadsheet->getActiveSheet()->getColumnDimension(chr(ord('A')+$key))->setAutoSize(true);
            $sheet->setCellValue(chr(ord('A')+$key).'1', $title);
        }

        $i = 2;

        foreach ($items as $item) {
            $c = 'A';
            $sheet->setCellValue($c++.$i, $item->user_id);
            $sheet->setCellValue($c++.$i, $item->user->balance);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->pid,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue($c++.$i, $item->transaction?$item->transaction->created_at->format('d.m.Y'):'');
            $sheet->setCellValue($c++.$i, ($item->payed?'':'-').$item->prod_price);
            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="finance.xlsx"');
        $writer->save('php://output');
    }

    public function transactions(Request $request)
    {
        abort_if(Gate::denies('transactions'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Transaction::when(request('ds'), function($q){
            $q->where('created_at', '>=', request('ds'));
        })->when(request('de'), function($q){
            $q->whereHas('transaction', function($q){
                $q->where('created_at', '<=', request('de').' 23:59');
            });
        })->when(request('s'), function($q){
            $q->where(function($q){
                $q->where('user_id', request('s'))->orWhere('id', request('s'))->orWhere('order', 'like', '%'.request('s').'%');
            });
        })->where('outgo', 0)->where('type', 1)->orderBy('id','desc')->paginate(20);

        return view('admin.ind.transactions', compact('items'));
    }
}
