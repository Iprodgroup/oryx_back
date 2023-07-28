<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
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
        $items = Parcel::where('user_id', Auth::user()->id)->where('status', $request->input('status', 0));
        if ($request->input('s', '')) {
            $items = $items->where('name', 'like', "%" . $request->input('s') . "%")
                ->orWhere('track', 'like', "%" . $request->input('s') . "%")
                ->orWhere('id', 'like', "%" . $request->input('s') . "%");
        }
        $items = $items->get();

        $cities = [];
        if ($request->input('status', 0) == 3) {
            $cities = ['Город'];
            $countries = Setting::where([['type', 2], ['active', 1]])->get();
            foreach ($countries as $country) {
                foreach (explode("\r\n", $country->value) as $value) {
                    $cities[$value] = $value;
                }
            }
        }
        return view('profile.parcels', compact('items', 'cities'));
    }

    public function create()
    {
        $recipients = [];
        foreach (Auth::user()->recipients as $recipient) {
            $recipients[$recipient->id] = $recipient->surname . ' ' . $recipient->name . ' ' . $recipient->fname;
        }
        $countries = Setting::where([['type', 2], ['active', 1]])->get();
        $countries_out = [];
        $cities = [];
        foreach ($countries as $country) {
            $countries_out[$country->name] = $country->name;
            foreach (explode("\r\n", $country->value) as $value) {
                $cities[$value] = $value;
            }
        }
        return view('profile.add-parcel', compact('recipients', 'countries_out', 'cities'));
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
            ]);

            if ($request['prod_price'] == null) {
                $request ['prod_price'] = 0;
            }

            $item = Parcel::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));

            $input_goods = $request->input('goods');
            $goods = [];

            for ($i = 0; $i < count($input_goods['name']); $i++) {
                $goods[] = new ParcelGood([
                    'parcel_id' => $item->id,
                    'name' => $input_goods['name'][$i],
                    'currency' => $input_goods['currency'][$i],
                    'price' => $input_goods['price'][$i],
                ]);
            }

            $item->goods()->saveMany($goods);


            //$item->push();

            $this->sendNotifiaction(Auth::user(), 'regp', ['track' => $item->track, 'fio' => $item->fio]);

            //Integration
            $fromClient = User::where('id', $item['user_id'])->get();
            $toClient = Recipient::where('id', $item['recipient_id'])->get();

            Log::info(['user id ' => $fromClient[0]['id']]);
            Log::info(['recipient id ' => $toClient[0]['id']]);

            $products = [];
            foreach ($goods as $good) {
                $products[] = [
                    "name" => $good['name'],
                    "quantity" => 1,
                    "product_price" => $good['price'],
                    "tracking_code" => $item['track']
                ];
            }
            $parcelIntegrationId = $this->createDial(
                $fromClient[0]['surname'] . ' ' . $fromClient[0]['name'], $this->validatePhone($fromClient[0]['phone']),
                $toClient[0]['surname'] . ' ' . $toClient[0]['name'], $this->validatePhone($toClient[0]['phone']),
                $item['track'], $products
            )['result']['id'];
            Parcel::where('id', $item['id'])->update(['integration_id' => $parcelIntegrationId]);
            //
            DB::commit();
            return redirect()->route('profile.parcels');
        } catch (\Exception $exception){
            DB::rollBack();
            abort(500);
        }
//        return redirect()->route('profile.parcels');
    }

    public function delete(Request $request, $id)
    {
        Parcel::where([['user_id', Auth::user()->id], ['id', $id], ['status', 0]])->delete();
        return redirect()->route('profile.parcels');
    }

    public function pay($id)
    {
        $currency = Setting::where('code', 'currency')->first()->value;
        $item = Parcel::where([['user_id', Auth::user()->id], ['id', $id]])->first();

        if (!$item) {
            return redirect()->back()->with('order_nf', 'order_nf');
        }

        if ($item->payed) {
            return redirect()->back()->with('order_payed', 'order_payed');
        }

        if (Transaction::where('parcel_id', $item->id)->where('type', 1)->first()) {
            return redirect()->back()->with('order_payed', 'order_payed');
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
            return redirect()->back()->with('order_error', 'order_error');
        }

        $tr->update(['order' => $res['orderId']]);

        return redirect()->away($res['formUrl']);


        /*$item = Parcel::where([['user_id',$user->id],['id', $id]])->first();
        if(!$item)  return redirect()->back()->with('not_found', 'not_found');
        if($user->balance < $item->prod_price) return redirect()->back()->with('balance', 'balance');
        if($item->payed)  return redirect()->back()->with('already_paid', 'already_paid');
        $user->balance -= $item->prod_price;
        $user->save();

        $item->payed = 1;

        if($item->country_out == 16){
            $item->in_date = Carbon::now();
            $item->status = 4;
        }

        $item->save();

        Transaction::create(['user_id'=>$user->id,'count'=>$item->prod_price,'outgo'=>1,'type'=>1,'parcel_id'=>$id]);

        return redirect()->route('profile.parcels', ['status'=>$item->status]);*/
    }

    public function payMany()
    {
        $currency = Setting::where('code', 'currency')->first()->value;

        $items = Parcel::where([['user_id', Auth::user()->id], ['payed', 0]])->whereIn('id', request('ids'))->get();
        if (!count($items))
            return redirect()->back()->with('order_nf_np', 'order_nf_np');

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

        $res = \App\Http\Controllers\Profile\ProfileController::sendSber('register.do', $vars);

        if (empty($res['orderId'])) {
            Log::debug(print_r(array_merge($vars, $res), 1));
            return redirect()->back()->with('order_error', 'order_error');
        }

        $tr->update(['order' => $res['orderId']]);

        return redirect()->away($res['formUrl']);
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
        if (!$item) return redirect()->back()->with('not_found', 'not_found');

        if (!$item->payed) return redirect()->back();

        $fill = $request->all();
        $fill['in_date'] = Carbon::now();
        $fill['status'] = 4;
        $item->update($fill);

        return redirect()->route('profile.parcels', ['status' => 4]);
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
        return redirect()->back();
    }

    //Integration
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
                //Надо или отловить ошибку или прервать процесс создания посылки
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

    private function validatePhone($phone){
        $phone = str_replace(" ","", $phone);
        $phone = str_replace("(","", $phone);
        $phone = str_replace(")","", $phone);
        $phone = str_replace("-","", $phone);
        if ($phone[0] != "+"){
            $phone = "+".$phone;
        } else if ($phone[0] == '8'){
            $phone = str_replace_first('8', '+7', $phone);
        }
        return $phone;
    }
    //
}
