<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipient;
use App\Models\Parcel;
use App\Models\Excel;
use App\Models\ParcelGood;
use Illuminate\Support\Facades\DB;

use Gate;
use Symfony\Component\HttpFoundation\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Facades\Auth;

class ParcelController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Parcel::when(request('out'), function($q){
            $q->where('country_out',request('out'));
        })->where('created_at', '>=', request('ds',now()->subMonth()->format('Y-m-d')))
        ->where('created_at', '<=', request('de',now()->format('Y-m-d')).' 23:59')
        ->when(request('city') && request('out',6)!=15, function($q){
            $q->where('city', 'like', request('city').'%');
        })->when(request('in_status'), function($q){
            $q->where('in_status', request('in_status')-1);
        })->when(request('in_city'), function($q){
            if(request('in_city')==1)
                $q->whereNotIn('in_city', ['Нур-Султан','Алматы']);
            else
                $q->where('in_city', request('in_city'));
        })->when(Auth::user()->city, function($q){
            $q->where('city', Auth::user()->city);
        })->when(request('s'), function($q){
            $q->where(function($q){
                $q->where('user_id', request('s'))->orWhere('track', 'like', '%'.request('s').'%');
            });
        });

        $count_ = clone $items;

		$items = $items->where('status', $request->input('status',0))->orderBy('id','desc')->paginate(50);
        $count_ = $count_->select(DB::raw('count(*) as c,status'))->groupBy('status')->get();
		$count = [];
		foreach ($count_ as $p) {
			$count[$p->status] = $p->c;
		}

        $items->appends(request()->except('page'));

        if(request('page') && $count[request('status',0)] < request('page',1)*50-50)
            return redirect()->route('parcels.index', array_replace(request()->all(),['page'=>1]));

        return view('admin.parcels.index', compact('items','count'));
    }

    public function create()
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = new Parcel();
        $users = Recipient::pluck('name','id');
        return view('admin.parcels.form', compact('item','users'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            // 'name'   =>  'required|max:190',
            'recipient_id'  =>  'required|exists:recipients,id',
            'goods'         =>  'required|array|min:1',
            'goods.name.*'  =>  'required',
            'goods.price.*' =>  'required',
        ]);

        $item = Parcel::create(array_merge($request->all(),['name'=>$request->track]));
        // $item->user_id = $item->recipient->user_id;
        // $item->save();

        $input_goods = $request->input('goods');
        $goods = [];

        for ($i=0; $i < count($input_goods['name']); $i++) {
            $goods[] = new ParcelGood([
                'parcel_id' => $item->id,
                'name' => $input_goods['name'][$i],
                'currency' => $input_goods['currency'][$i],
                'price' => $input_goods['price'][$i],
            ]);
        }

        $item->goods()->saveMany($goods);

        return redirect()->route('parcels.index');
    }

    public function edit(Parcel $item, $id)
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $item = Parcel::findOrFail($id);
        $users = Recipient::pluck('name','id');
        return view('admin.parcels.form', compact('item','users'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            // 'name'   =>  'required|max:190',
            'track'         =>  'required|max:190',
            'recipient_id'  =>  'required|exists:recipients,id',
        ]);

        $item = Parcel::findOrFail($id);
        $prod_price = $item->prod_price;
        $fill = $request->all();
        $fill['prod_price'] = str_replace(',','.',$fill['prod_price']);
        if($request->status==10 && !$item->payed)
            unset($fill['status']);

        $item->update($fill);
        $item->update(['user_id'=>$item->recipient->user_id]);

        if($fill['prod_price'] == $prod_price)
            

        return redirect()->route('parcels.index');
    }

    public function delete(Request $request)
    {
        abort_if(Gate::denies('parcels'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(count($request->input('id',[])))
            Parcel::whereIn('id',$request->input('id',[]))->delete();
        return redirect()->route('parcels.index');
    }

    public function upload(Request $request)
    {
        if ($request->file('file')) {
        	$item = Excel::create();
            $item->addMediaFromRequest('file')->toMediaCollection('excel');
            return redirect()->route('parcels.excel',$item->id);
        }
    }

    public function load(Request $request, $status = 0)
    { 
        if (!$request->input('out') || $request->input('out') == 0) {
            $out = 6;
        } else {
            $out = $request->input('out');
        }
        
        $items = Parcel::where('status', $status)
        ->where('country_out', $out)
        ->where('created_at', '>=', request('ds',now()->subMonth()->format('Y-m-d')).' 00:00')
        ->where('created_at', '<=', request('de',now()->format('Y-m-d')).' 23:59')
        ->when(request('city') && request('out',6)!=15, function($q){
            $q->where('city', 'like', request('city').'%');
        })->when(request('in_status'), function($q){
            $q->where('in_status', request('in_status')-1);
        })->when(request('in_city'), function($q){
            if(request('in_city')==1)
                $q->whereNotIn('in_city', ['Нур-Султан','Алматы']);
            else
                $q->where('in_city', request('in_city'));
        })->when(Auth::user()->city, function($q){
            $q->where('city', Auth::user()->city);
        })->when(request('s'), function($q){
            $q->where('user_id', request('s'))->orWhere('track', 'like', '%'.request('s').'%');
        })->orderBy('id','desc')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // $header = ['UID','ФИО','Трек','Трек СДЭК','Декларации','Вес','Цена','Договор','Паспорт'];
        $header = ['UID','Трек-номер','Город доставки','Наименование','ФИО получателя'];

        if($status>=2){
            $header[] = 'Вес';
            $header[] = 'Номер посылки';
        }

        if($status>=4 || request('out')==15)
            $header = ['UID','Трек','Номер посылки','Трек по стране','ФИО получателя','Город','Адрес','Телефон','Вес','Комментарий','Оплата'];

        $header[] = 'Стоимость';
        $header[] = 'Фото 1';
        $header[] = 'Фото 2';

        foreach ($header as $key => $title) {
            $spreadsheet->getActiveSheet()->getColumnDimension(chr(ord('A')+$key))->setAutoSize(true);
            $sheet->setCellValue(chr(ord('A')+$key).'1', $title);
        }

        $i = 2;
        
        foreach ($items as $item) {
         
            $c = 'A';
            if($status>=4 || request('out')==15){
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
            }else{
                $sheet->setCellValue($c++.$i, $item->user_id);
                $spreadsheet->getActiveSheet()->getCell($c++.$i)->setValueExplicit($item->track,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue($c++.$i, $item->in_city ?? $item->city);
                $str = '';
                foreach ($item->goods as $good) {
                    if($str) $str .= ', ';
                    $str .= $good->name;
                }
                $sheet->setCellValue($c++.$i, $str);

                $sheet->setCellValue($c++.$i, ($item->recipient->surname??'').' '.($item->recipient->name??'').' '.($item->recipient->fname??''));

                if($status>=2){
                    $sheet->setCellValue($c++.$i, $item->weight);
                    $sheet->setCellValue($c++.$i, $item->pid);
                }
            }

            $sheet->setCellValue($c++.$i, $item->goods->sum('price'));
          
           if ($item->recipient) {
            foreach ($item->recipient->getMedia('pass')->all() as $pass){
                $sheet->setCellValue($c.$i, $pass->getUrl());
                $sheet->getCell($c.$i)->getHyperlink()->setUrl($pass->getUrl());
                $c++;
            }
           }    

            $i++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="list.xlsx"');
        $writer->save('php://output');
    }

    public function excel(Request $request, $id)
    {
        $item = Excel::find($id);
        $t = $request->input('t','');

        //print_r($item->getMedia('excel')->first()->toArray());
        // echo storage_path('app/public/'.$item->getMedia('excel')->first()->id.'/'.$item->getMedia('excel')->first()->file_name);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public/'.$item->getMedia('excel')->first()->id.'/'.$item->getMedia('excel')->first()->file_name));
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		//echo '<pre>';print_r($sheetData);exit;

        $tracks = [];
        $tracks6 = [];
        $isset = [];
        $items2 = [];
        foreach ($sheetData as $i=>$c) {
            if($i==1) continue;
        	if($c['A']){
	        	$tracks[] = $c['A'];
                $tracks6[] = substr($c['A'], -6);
                $isset[$c['A']] = $c['A'];
	        	$tracks_full[] = [$c['A'],$c['B'],$c['C']??'',$c['D']??'',$c['E']??'',$c['F']??''];
	        }
        }

        $items0 = Parcel::whereIn('track',$tracks)->get();

    	$items1 = Parcel::whereNotIn('track',$tracks)->where(function($q) use ($tracks6){
        	foreach($tracks6 as $track){
			    $q->orWhere('track', 'LIKE', '%'.$track.'%');
			}
		})->get();

        foreach ($items0 as $item) {
            if(isset($isset[(string)$item->track]))
                unset($isset[(string)$item->track]);
        }

        foreach ($items1 as $item) {
            foreach ($isset as $k=>$is) {
                if(strpos((string)$item->track, (string)$is) !== false)
                    unset($isset[$k]);
            }
        }

        foreach ($isset as $track) {
            $item = new Parcel();
            $item->track = $track;
            $items2[] = $item;
        }

		return view('admin.parcels.excel', compact('items0','items1','items2','id','t','tracks','tracks6','tracks_full'));
    }

    public function replace(Request $request, $id)
    {
    	$status = array_flip(__('ui.status'));
    	if($request->input('pid')){
    		$item = Parcel::find($request->input('pid'));

    		if($request->input('p')){
    			$item->pid = $request->input('p');
    		}
            if($request->input('r')){
                $item->track = $request->input('r');
            }
            if($request->input('w')){
                $item->weight = str_replace(',','.',$request->input('w'));
                $item->prod_price = $item->weight*$item->user->tariff[$item->country_out]+($item->country_out>6 && $item->weight<1?3.5:0);
            }
            if($request->input('d')){
                $item->date_out = \Carbon\Carbon::parse($request->input('d'))->format('Y-m-d');
            }
            if($request->input('it')){
                $item->in_track = $request->input('it');
            }

            // $oldStatus = $item->status;

            if(isset($status[$request->input('status')]))
        		$item->status = $status[$request->input('status')];

    		$item->save();
    	}
        return redirect()->route('parcels.excel',$id);
    }

    public function replaces(Request $request, $id)
    {
        if(!is_array(request('id')))
            return redirect()->route('parcels.excel',$id);
    	$status = array_flip(__('ui.status'));
        $r = $request->all();

        foreach ($r['id'] as $parcel_id) {
            if(isset($r['status'][$parcel_id])){
                $item = Parcel::find($parcel_id);

                if($r['r'][$parcel_id] ?? '')
                    $item->track = $r['r'][$parcel_id];

                if($r['p'][$parcel_id] ?? '')
                    $item->pid = $r['p'][$parcel_id];

                if($r['w'][$parcel_id] ?? ''){
                    $item->weight = str_replace(',','.',$r['w'][$parcel_id]);
                    $item->prod_price = $item->weight*$item->user->tariff[$item->country_out]+($item->country_out>6 && $item->weight<1?3.5:0);
                }

                if($r['d'][$parcel_id] ?? '')
                    $item->date_out = \Carbon\Carbon::parse($r['d'][$parcel_id])->format('Y-m-d');

                if($r['it'][$parcel_id] ?? '')
                    $item->in_track = $r['it'][$parcel_id];


                if($r['status'][$parcel_id] ?? '')
                    $item->status = $status[$r['status'][$parcel_id]];

                $item->save();
            }
        }
        return redirect()->route('parcels.excel',$id);
    }
}
