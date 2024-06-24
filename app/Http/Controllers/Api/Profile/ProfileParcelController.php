<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Address;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parcel;
use App\Models\ParcelGood;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Recipient;
use Illuminate\Support\Facades\DB;

class ProfileParcelController extends Controller
{
	public function index(Request $request)
	{
		$items = Parcel::with('goods')
			->where('user_id', Auth::user()->id);

		// Добавить фильтрацию по статусу только если статус указан в запросе
		if ($request->has('status')) {
			$items = $items->where('status', $request->input('status'));
		}

		// Фильтрация по поисковому запросу
		if ($request->input('s', '')) {
			$items = $items->where(function ($query) use ($request) {
				$query->where('name', 'like', "%" . $request->input('s') . "%")
					->orWhere('track', 'like', "%" . $request->input('s') . "%")
					->orWhere('id', 'like', "%" . $request->input('s') . "%");
			});
		}

		$items = $items->get();

		$cities = [];
		if ($request->input('status') == 3) {
			$cities = ['Город'];
			$countries = Setting::where([['type', 2], ['active', 1]])->get();
			foreach ($countries as $country) {
				foreach (explode("\r\n", $country->value) as $value) {
					$cities[$value] = $value;
				}
			}
		}

		return response()->json(['items' => $items, 'cities' => $cities]);
	}

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                //'name'          =>  'required|max:190',
                'track' => 'required|max:190',
                'recipient_id' => 'required',
                'goods.name.*' => 'required',
                'goods.price.*' => 'required|numeric|min:0',
                'city_out' => 'required'
            ]);

            if ($request['prod_price'] == null) {
                $request['prod_price'] = 0;
            }

            $country = Address::where('id', $request['city_out'])->first();

            if ($country) {
                $request['country_out'] = (int)$country->tab;
            }

            $item = Parcel::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));

            $input_goods = $request->input('goods');
            $goods = [];

            $count = count($input_goods['name']);

            for ($i = 0; $i < $count; $i++) {
                $goods[] = new ParcelGood([
                    'parcel_id' => $item->id,
                    'name' => $input_goods['name'][$i],
                    'currency' => $input_goods['currency'][$i],
                    'price' => $input_goods['price'][$i],
                ]);
            }

            $item->goods()->saveMany($goods);

            $this->sendNotifiaction(Auth::user(), 'regp', ['track' => $item->track, 'fio' => $item->fio]);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Parcel created successfully', 'item' => $item]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        Parcel::where([['user_id', Auth::user()->id], ['id', $id], ['status', 0]])->delete();
        return response()->json(['status' => 'success', 'message' => 'Parcel deleted successfully']);
    }

    public function pay($id)
    {
        $currency = Setting::where('code', 'currency')->first()->value;
        $item = Parcel::where([['user_id', Auth::user()->id], ['id', $id]])->first();

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Parcel not found']);
        }

        if ($item->payed) {
            return response()->json(['status' => 'error', 'message' => 'Parcel already paid']);
        }

        if (Transaction::where('parcel_id', $item->id)->where('type', 1)->first()) {
            return response()->json(['status' => 'error', 'message' => 'Parcel already paid']);
        }

        $tr = Transaction::create([
            'user_id' => Auth::user()->id,
            'parcel_id' => $item->id,
            'count' => $item->prod_price,
            'tenge' => round($item->prod_price * $currency, 2)
        ]);

        $vars = [
            'orderNumber' => $tr->id,
            'amount' => $tr->tenge * 100,
            'currency' => 398,
            'returnUrl' => route('profile.success'),
            'failUrl' => route('profile.error'),
            'description' => 'Пополнение баланса на сайте ' . env('APP_NAME'),
        ];

        $res = \App\Http\Controllers\Profile\ProfileController::sendSber('register.do', $vars);

        if (empty($res['orderId'])) {
            Log::debug(print_r(array_merge($vars, $res), 1));
            return response()->json(['status' => 'error', 'message' => 'Order error']);
        }

        $tr->update(['order' => $res['orderId']]);

        return response()->json(['status' => 'success', 'redirect_url' => $res['formUrl']]);
    }

    public function payMany(Request $request)
    {
        $currency = Setting::where('code', 'currency')->first()->value;

        $items = Parcel::where([['user_id', Auth::user()->id], ['payed', 0]])->whereIn('id', $request->input('ids', []))->get();
        if (!count($items)) {
            return response()->json(['status' => 'error', 'message' => 'No parcels found']);
        }
		
        $ids = [];
        $prod_price = 0;
        foreach ($items as $item) {
            $ids[] = $item->id;
            $prod_price += $item->prod_price;
        }
		
	
		
        $tr = Transaction::create([
            'user_id' => Auth::user()->id,
            'count' => $prod_price,
            'tenge' => round($prod_price * $currency, 2)
        ]);


        $tr->parcels()->sync($ids);

        $vars = [
            'orderNumber' => $tr->id,
            'amount' => $tr->tenge * 100,
            'currency' => 398,
            'returnUrl' => route('profile.success'),
            'failUrl' => route('profile.error'),
            'description' => 'Пополнение баланса на сайте ' . env('APP_NAME'),
        ];

        $res = \App\Http\Controllers\Api\Profile\ProfileController::sendSber('register.do', $vars);
        if (empty($res['orderId'])) {
            return response()->json(['status' => 'error', 'message' => 'Order error']);
        }

        $tr->update(['order' => $res['orderId']]);

        return response()->json(['status' => 'success', 'redirect_url' => $res['formUrl']]);
    }

    public function delivery(Request $request, $id)
    {
        $request->validate([
            'in_fio' => 'required|max:190',
            'in_city' => 'required|max:190',
            'in_address' => 'required|max:190',
        ]);

        $user = Auth::user();
        $item = Parcel::where([['user_id', $user->id], ['id', $id]])->first();
        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Parcel not found']);
        }

        if (!$item->payed) {
            return response()->json(['status' => 'error', 'message' => 'Parcel not paid']);
        }

        $fill = $request->all();
        $fill['in_date'] = Carbon::now();
        $fill['status'] = 4;
        $item->update($fill);

        return response()->json(['status' => 'success', 'message' => 'Parcel delivery updated']);
    }

    public function deliveryMany(Request $request)
    {
        $request->validate([
            'in_fio' => 'required|max:190',
            'in_city' => 'required|max:190',
            'in_address' => 'required|max:190',
        ]);

        $user = Auth::user();

        $fill = $request->except(['_token', 'ids']);
        $fill['in_date'] = Carbon::now();
        $fill['status'] = 4;

        Parcel::where([['user_id', $user->id], ['status', 3], ['payed', 1]])->whereIn('id', $request->input('ids', []))->update($fill);
        return response()->json(['status' => 'success', 'message' => 'Parcels delivery updated']);
    }

    // Integration
    private function requestBuilder($url_method)
    {
        $API_KEY = '109bb709-95e6-410e-9323-aecfc1b0b923';
        $PHONE = '+77012068005';
        $BASE_URL = 'https://api.havoex.gocrm.uz/api';

        $headers = array(
            'Content-Type' => 'application/json',
            'Api-key' => $API_KEY,
            'Phone' => $PHONE
        );
        return array(
            'uri' => $BASE_URL . $url_method,
            'headers' => $headers,
        );
    }

    private function createDial($fromName, $fromPhone, $toName, $toPhone, $trackingCode, $products)
    {
        $FROM_FILIAL_ID = 1;
        $TO_FILIAL_ID = 3;
        $DIRECTION_TARIFF_ID = 2;

        $endPoint = '/account/partnerApi/createDeal';

        $fromUser = $this->checkUser($fromName, $fromPhone);
        $toUser = $this->checkUser($toName, $toPhone);

        Log::info(['create Dial user data ' => $fromUser]);
        Log::info(['create Dial recipient data ' => $toUser]);


        $body = [
            'from_filial_id' => $FROM_FILIAL_ID,
            'to_filial_id' => $TO_FILIAL_ID,
            'direction_tariff_id' => $DIRECTION_TARIFF_ID,
            'from_client_id' => $fromUser['client_id'],
            'from_phone' => $fromPhone,
            'to_client_id' => $toUser['client_id'],
            'to_phone' => $toPhone,
            'parcel' => [
                'weight' => 1,
                'parcel_products' => $products
            ]
        ];

        $data = $this->requestBuilder($endPoint);
        $client = new Client();
        return json_decode($client->post(
            $data['uri'],
            array('headers' => $data['headers'],
                'json' => $body)
        )->getBody()->getContents(), true);
    }

    private function createUser($name, $phone)
    {
        $endPoint = '/clients';

        $body = [
            'name' => $name,
            'phone' => $phone,
            'country_id' => 3
        ];

        $data = $this->requestBuilder($endPoint);
        $client = new Client();
        return json_decode($client->post(
            $data['uri'],
            array('headers' => $data['headers'],
                'json' => $body)
        )->getBody()->getContents(), true);
    }

    private function findUserByPhone($phone)
    {
        $endPoint = '/clients/inventory';

        $queryParams = [
            'search' => $phone
        ];

        $data = $this->requestBuilder($endPoint);
        $client = new Client();
        return json_decode($client->get(
            $data['uri'],
            array('headers' => $data['headers'],
                'json' => $queryParams)
        )->getBody()->getContents(), true);
    }

    private function checkUser($name, $phone)
    {
        $user = $this->findUserByPhone($phone);
        Log::info(['user find = ' => $user]);
        if (empty($user['result']['data']['clients'])) {
            Log::info(['user not find']);
            $createUser = $this->createUser($name, $phone);
            Log::info(['create user' => $createUser]);
            if ($createUser['result']['success']) {
                Log::info(['create user successfully']);
                $client_id = $createUser['result']['data']['client']['id'];
                $client_phone = $createUser['result']['data']['client']['phone'];
                Log::info(['client id' => $client_id, 'client phone' => $client_phone]);
            } else {
                //Надо продумать че делать если юзер которого мы ходим сохранить не сохранился, пока пустые значения поставил
                //Надо или отловить че делать с ошибкой
                Log::info(['user does not create, error!']);
                $client_id = '';
                $client_phone = '';
            }
        } else {
            Log::info(['user find in db uzbekov']);
            $client_id = $user['result']['data']['clients'][0]['id'];
            $client_phone = $user['result']['data']['clients'][0]['phone'];
            Log::info(['client id' => $client_id, 'client phone' => $client_phone]);
        }
        return [
            'client_id' => $client_id,
            'phone' => $client_phone
        ];
    }

    private function validatePhone($phone)
    {
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $phone = str_replace("-", "", $phone);
        if ($phone[0] != "+") {
            $phone = "+" . $phone;
        } else if ($phone[0] == '8') {
            $phone = str_replace_first('8', '+7', $phone);
        }
        return $phone;
    }
}
