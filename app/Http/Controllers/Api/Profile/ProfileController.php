<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipient;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Instead;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Profile index'], 200);
    }

    public function settings(Request $request)
	{
		// Обработка POST-запроса
		if ($request->isMethod('post')) {
			if (!$request->input('name') || !$request->input('surname'))
				return response()->json(['error' => 'Name and Surname are required'], 400);

			$user = Auth::user();
			$fill = $request->only(['name', 'fname', 'surname', 'phone', 'password']);
			$fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);

			if (!$fill['password']) {
				unset($fill['password']);
			} else {
				$fill['password'] = Hash::make($fill['password']);
			}

			$user->update($fill);
			return response()->json(['message' => 'Settings updated'], 200);
		}

		// Обработка GET-запроса
		if ($request->isMethod('get')) {
			$user = Auth::user();
			$recipients = $user->recipients; // Предполагается, что у пользователя есть связь "recipients"

			return response()->json(['recipients' => $recipients], 200);
		}

		return response()->json(['error' => 'Method not allowed'], 405);
	}

    public function nsettings(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->input('notifications')) {
                $item = Auth::user();
                $settings = $item->settings;
                foreach ($request->input('notifications') as $key => $value) {
                    $settings[$key] = $value;
                }
                $item->settings = $settings;
                $item->save();
            }
            return response()->json(['message' => 'Notification settings updated'], 200);
        }

        return response()->json(['message' => 'Notification settings page'], 200);
    }

    public function recipients_add(Request $request)
    {
        if (!$request->input('name') || !$request->input('surname'))
            return response()->json(['error' => 'Name and Surname are required'], 400);

        $item = new Recipient();
        $item->fill(array_merge($request->all(), ['user_id' => Auth::user()->id]));
        $item->save();

        $files = [];
        $hash = Hash::make('link has been connected');
        if ($request->file('file1')) {
            $originalName = $request->file('file1')->getClientOriginalName();
            $path = "recipients/$item->id/" . $hash . $originalName;

            Storage::disk('private')->put($path, file_get_contents($request->file('file1')));
            $files[] = $path;
        }
        if ($request->file('file2')) {
            $originalName = $request->file('file2')->getClientOriginalName();
            $path = "recipients/$item->id/" . $hash . $originalName;

            Storage::disk('private')->put($path, file_get_contents($request->file('file2')));
            $files[] = $path;
        }
        $item->files = json_encode($files);
        $item->save();

        return response()->json(['message' => 'Recipient added'], 200);
    }

    public function addresses()
    {
        return response()->json(['message' => 'Addresses page'], 200);
    }

    public function balance(Request $request)
    {
        $currency = Setting::where('code', 'currency')->first()->value;

        if ($request->isMethod('post')) {
            $user = Auth::user();
            $request->validate([
                'count' => 'required|numeric|between:1,999999'
            ]);
            $tr = Transaction::create(['user_id' => $user->id, 'count' => $request->input('count'), 'tenge' => round($request->input('count') * $currency, 2)]);

            $vars = [
                'orderNumber' => $tr->id,
                'amount' => $tr->tenge * 100,
                'currency' => 398,
                'returnUrl' => route('profile.success'),
                'failUrl' => route('profile.error'),
                'description' => 'Пополнение баланса на сайте ' . env('APP_NAME'),
            ];

            $res = $this->sendSber('register.do', $vars);

            if (empty($res['orderId'])) {
                Log::debug(print_r(array_merge($vars, $res), 1));
                return response()->json(['error' => 'Order error'], 400);
            }

            $tr->update(['order' => $res['orderId']]);

            return response()->json(['url' => $res['formUrl']], 200);
        }

        return response()->json(['currency' => $currency], 200);
    }

    public function callback(Request $request)
    {
        Log::debug('callback');
        Log::debug(print_r($request->all(), 1));

        if (!$request->input('mdOrder')) abort(404);

        $tr = Transaction::where('order', $request->input('mdOrder'))->where('id', $request->input('orderNumber'))->first();

        if (!$tr) abort(404);
        if ($tr->type) return;
        $res = $this->sendSber('getOrderStatus.do', ['orderId' => $tr->order]);
        if ($res['ErrorCode'] == 6) return;
        if ($res['OrderStatus'] != 2) return;

        $tr->update(['type' => 1]);

        if ($tr->parcel) {
            $tr->parcel->update(['payed' => 1]);
            if ($tr->parcel->country_out == 16)
                $tr->parcel->update(['in_date' => Carbon::now(), 'in_date' => 4]);
            $this->sendNotification($tr->user, 'balance', ['fio' => $tr->user->fio, 'track' => $tr->parcel->track]);
        } else {
            foreach ($tr->parcels as $parcel) {
                $parcel->update(['payed' => 1]);
                if ($parcel->country_out == 16)
                    $parcel->update(['in_date' => Carbon::now(), 'in_date' => 4]);
                $this->sendNotification($tr->user, 'balance', ['fio' => $parcel->user->fio, 'track' => $parcel->track]);
            }
        }
    }

    public function success(Request $request)
    {
        Log::debug('success');
        Log::debug(print_r($request->all(), 1));

        $tr = Transaction::where('order', $request->input('orderId'))->first();
        if (!$tr) return redirect()->route('profile.balance')->with('order_return_error', '');
        if ($tr->type) return redirect()->route('profile.balance')->with('order_return_error', '');

        $res = $this->sendSber('getOrderStatus.do', ['orderId' => $tr->order]);
        if ($res['ErrorCode'] == 6) return redirect()->route('profile.parcels')->with('order_return_error', '');
        if ($res['OrderStatus'] == 2) {
            $tr->update(['type' => 1]);

            if ($tr->parcel) {
                $tr->parcel->update(['payed' => 1]);
                if ($tr->parcel->country_out == 16)
                    $tr->parcel->update(['in_date' => Carbon::now(), 'in_date' => 4]);
                $this->sendNotification($tr->user, 'balance', ['fio' => $tr->user->fio, 'track' => $tr->parcel->track]);
            } else {
                foreach ($tr->parcels as $parcel) {
                    $parcel->update(['payed' => 1]);
                    if ($parcel->country_out == 16)
                        $parcel->update(['in_date' => Carbon::now(), 'in_date' => 4]);
                    $this->sendNotification($tr->user, 'balance', ['fio' => $parcel->user->fio, 'track' => $parcel->track]);
                }
            }
        }
        return response()->json(['message' => 'Success'], 200);
    }

    public function error(Request $request)
    {
        return response()->json(['message' => 'Error'], 400);
    }

    public function notifications(Request $request)
    {
        $items = Notification::where('user_id', Auth::user()->id)->orderBy('read')->orderBy('created_at', 'desc')->get();
        $read = Notification::where('user_id', Auth::user()->id)->where('read', 0)->count();

        if ($request->input('read')) {
            $items = $items->where('read', 0);
        }

        return response()->json(['notifications' => $items, 'unread_count' => $read], 200);
    }

    public function notification(Request $request, $id)
    {
        $item = Notification::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if (!$item) return response()->json(['error' => 'Notification not found'], 404);

        $item->read = 1;
        $item->save();
        return response()->json(['notification' => $item], 200);
    }

    public function notificationsr(Request $request)
    {
        Notification::where('user_id', Auth::user()->id)->update(['read' => 1]);
        return response()->json(['message' => 'All notifications marked as read'], 200);
    }

    public function transactions(Request $request)
    {
        $items = Transaction::where('user_id', Auth::user()->id)->where('type', 1);

        if ($request->input('outgo', -1) >= 0) {
            $items->where('outgo', $request->input('outgo'));
        }

        $items = $items->get();
        return response()->json(['transactions' => $items], 200);
    }

    public function referal(Request $request)
    {
        $referals = Referal::with(['friend'])->whereHas('friend')->where('user_id', Auth::user()->id)->get();
        return response()->json(['referals' => $referals], 200);
    }

    public function instead(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
        ]);
		
        Instead::create(array_merge(['user_id' => Auth::user()->id], $request->all()));

        return response()->json(['message' => 'Instead created'], 200);
    }

    static function sendSber($method, $vars)
    {
        $vars = array_merge($vars, ['userName' => env('SBER_LOGIN'), 'password' => env('SBER_PASSWORD')]);
        $ch = curl_init('https://securepayments.sberbank.kz/payment/rest/' . $method . '?' . http_build_query($vars));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, 1);
    }
}
