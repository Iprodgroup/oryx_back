<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipient;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Instead;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function settings(Request $request)
    {
    	if($request->method() == 'POST'){
    		if(!$request->input('name') || !$request->input('surname'))
    			return redirect()->route('profile.settings');
    		$item = Auth::user();
            $fill = $request->only(['name', 'fname', 'surname','phone','password']);
            $fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);

            if(!$fill['password'])  unset($fill['password']);
            else $fill['password'] = Hash::make($fill['password']);

    		$item->update($fill);
    		return redirect()->route('profile.settings');
    	}
        return view('profile.settings');
    }

    public function nsettings(Request $request)
    {
    	if($request->method() == 'POST'){
    		if($request->input('notifications')){
	    		$item = Auth::user();
	    		$settings = $item->settings;
	    		foreach ($request->input('notifications') as $key => $value) {
	    			$settings[$key] = $value;
	    		}
	    		$item->settings = $settings;
	    		$item->save();
	    	}
    		return redirect()->route('profile.nsettings');
    	}
        return view('profile.nsettings');
    }

    public function recipients_add(Request $request)
    {
        if(!$request->input('name') || !$request->input('surname'))
			return redirect()->route('profile.nsettings');
		$item = new Recipient();
		$item->fill(array_merge($request->all(),['user_id'=>Auth::user()->id]));
		$item->save();
		if ($request->file('file1'))
            $item->addMediaFromRequest('file1')->usingFileName(Str::slug($request->file1->getClientOriginalName()).'.'.$request->file2->getClientOriginalExtension())->toMediaCollection('pass');
        if ($request->file('file2'))
            $item->addMediaFromRequest('file2')->usingFileName(Str::slug($request->file2->getClientOriginalName()).'.'.$request->file2->getClientOriginalExtension())->toMediaCollection('pass');
        // if ($request->file('file3'))
          //   $item->addMediaFromRequest('file3')->toMediaCollection('contract');

		return redirect()->route('profile.nsettings');
    }

    public function addresses()
    {
        return view('profile.addresses');
    }

    public function balance(Request $request)
    {
        $currency = Setting::where('code','currency')->first()->value;

        if($request->isMethod('post')){
            exit;
            $user = Auth::user();
            $request->validate([
                'count'    => 'required|numeric|between:1,999999'
            ]);
            $tr = Transaction::create(['user_id'=>$user->id,'count'=>$request->input('count'),'tenge'=>round($request->input('count')*$currency,2)]);

            $vars = [
                'orderNumber' => $tr->id,
                'amount' => $tr->tenge*100,
                'currency' => 398,
                'returnUrl' => route('profile.success'),
                'failUrl' => route('profile.error'),
                'description' => 'Пополнение баланса на сайте '.env('APP_NAME'),
            ];

            $res = $this->sendSber('register.do',$vars);

            if (empty($res['orderId'])){
                Log::debug(print_r(array_merge($vars,$res),1));
                return redirect()->back()->with('order_error', 'order_error');
            }

            $tr->update(['order'=>$res['orderId']]);

            return redirect()->away($res['formUrl']);
        }
        return view('profile.balance',compact('currency'));
    }

    public function callback(Request $request)
    {
        Log::debug('callback');
        Log::debug(print_r($request->all(),1));

        if(!$request->input('mdOrder')) abort(404);

        $tr = Transaction::where('order',$request->input('mdOrder'))->where('id',$request->input('orderNumber'))->first();

        if(!$tr) abort(404);
        if($tr->type) return;
        $res = $this->sendSber('getOrderStatus.do',['orderId' => $tr->order]);
        if($res['ErrorCode']==6) return;
        if($res['OrderStatus']!=2) return;

        $tr->update(['type'=>1]);

        if($tr->parcel){
            $tr->parcel->update(['payed'=>1]);
            if($tr->parcel->country_out == 16)
                $tr->parcel->update(['in_date'=>Carbon::now(),'in_date'=>4]);
            $this->sendNotifiaction($tr->user, 'balance', ['fio'=>$tr->user->fio,'track'=>$tr->parcel->track]);
        }else{
            foreach ($tr->parcels as $parcel) {
                $parcel->update(['payed'=>1]);
                if($parcel->country_out == 16)
                $parcel->update(['in_date'=>Carbon::now(),'in_date'=>4]);
                $this->sendNotifiaction($tr->user, 'balance', ['fio'=>$tr->user->fio,'track'=>$parcel->track]);
            }
        }
    }

    public function success(Request $request)
    {
        Log::debug('success');
        Log::debug(print_r($request->all(),1));

        $tr = Transaction::where('order',$request->input('orderId'))->first();
        if(!$tr) return redirect()->route('profile.balance')->with('order_return_error', '');
        if($tr->type) return redirect()->route('profile.balance')->with('order_return_error', '');

        $res = $this->sendSber('getOrderStatus.do',['orderId' => $tr->order]);
        if($res['ErrorCode']==6) return redirect()->route('profile.parcels')->with('order_return_error', '');
        if($res['OrderStatus']==2){
            $tr->update(['type'=>1]);

            if($tr->parcel){
                $tr->parcel->update(['payed'=>1]);
                if($tr->parcel->country_out == 16)
                    $tr->parcel->update(['in_date'=>Carbon::now(),'in_date'=>4]);
                $this->sendNotifiaction($tr->user, 'balance', ['fio'=>$tr->user->fio,'track'=>$tr->parcel->track]);
            }else{
                foreach ($tr->parcels as $parcel) {
                    $parcel->update(['payed'=>1]);
                    if($parcel->country_out == 16)
                    $parcel->update(['in_date'=>Carbon::now(),'in_date'=>4]);
                    $this->sendNotifiaction($tr->user, 'balance', ['fio'=>$tr->user->fio,'track'=>$parcel->track]);
                }
            }

            /*$tr->parcel->update(['payed'=>1]);
            if($tr->parcel->country_out == 16)
                $tr->parcel->update(['in_date'=>Carbon::now(),'in_date'=>4]);
            $this->sendNotifiaction($tr->user, 'balance', ['fio'=>$tr->user->fio,'track'=>$tr->parcel->track]);*/
        }
        return view('profile.success', compact('res'));
    }

    public function error(Request $request)
    {
        return view('profile.error');
    }

    public function notifications(Request $request)
    {
        $items = Notification::where('user_id',Auth::user()->id)->orderBy('read')->orderBy('created_at','desc');
        // $total = Notification::where('user_id',Auth::user()->id)->count();
        $read = Notification::where('user_id',Auth::user()->id)->where('read',0)->count();
        if ($request->input('read')) {
            $items->where('read',0);
        }
        $items = $items->get();
        return view('profile.notifications', compact('items','read'));
    }

    public function notification(Request $request, $id)
    {
        $item = Notification::where('user_id',Auth::user()->id)->where('id',$id)->first();
        if(!$item) abort(404);
        $item->read = 1;
        $item->save();
        return view('profile.notification', compact('item'));
    }

    public function notificationsr(Request $request)
    {
        Notification::where('user_id',Auth::user()->id)->update(['read' => 1]);
        return redirect()->route('profile.notifications');
    }

    public function transactions(Request $request)
    {
        $items = Transaction::where('user_id',Auth::user()->id)->where('type',1);
        if ($request->input('outgo',-1)>=0) {
            $items->where('outgo',$request->input('outgo'));
        }
        $items = $items->get();
        return view('profile.transactions', compact('items'));
    }

    public function referal(Request $request)
    {
        return view('profile.referal');
    }

    public function instead(Request $request)
    {
        $request->validate([
            'name'   =>  'required|max:190',
            //'link'   =>  'required|max:190',
        ]);

        Instead::create(array_merge(['user_id'=>Auth::user()->id],$request->all()));

        return redirect()->route('profile.index')->with('instead', 1);
    }

    static function sendSber($method,$vars) {
        $vars = array_merge($vars, ['userName' => env('SBER_LOGIN'),'password' => env('SBER_PASSWORD')]);
        //dd('https://securepayments.sberbank.kz/payment/rest/'.$method.'?' . http_build_query($vars));
        $ch = curl_init('https://securepayments.sberbank.kz/payment/rest/'.$method.'?' . http_build_query($vars));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res,1);
    }
}
