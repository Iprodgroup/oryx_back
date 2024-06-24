<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index()
    {
        $reviews = Review::where('status', 'active')->get();
        $questions = Question::where('status', 'active')->get();
        $products = Product::where('status', 'active')->inRandomOrder()->take(8)->get();

        //dd($reviews);
        return view('home', ['reviews' => $reviews, 'questions' => $questions, 'products' => $products]);
    }

    public function notif()
    {
        return view('auth.verify');
    }

    public function confirm(Request $request)
    {
    	if($request->method() === 'POST'){

    		$item = Auth::user();
            $fill = $request->only(['name', 'fname', 'surname', 'email', 'phone']);
            if(isset($fill['phone']))
                $fill['phone'] = preg_replace("/[^0-9]/", '', $fill['phone']);
    		$item->fill($fill);
    		$item->save();

            //Bitrix24 integration
            $bitrixUser = $item->toArray();
            $this->checkContactBitrixByOrx($bitrixUser);
            //

    		return redirect()->route('register.completed');
    	}
        $item = Auth::user();
        return view('auth.confirm', compact('item'));
    }

    public function completed(Request $request)
    {
        return view('auth.completed');
    }

    public function login(Request $request)
    {
    	if (Auth::check()) {
    		return redirect()->route('admin.index');
    	}
        return view('auth.admin-login');
    }

    public function checkContactBitrixByOrx($bitrixUser){
        Log::info("checkContactBitrix");

        $queryUrl = "https://orix.bitrix24.kz/rest/180/z61hnycx6b9254zm/crm.contact.list";
        $queryData = http_build_query(array(
            'filter' => [
                'UF_CRM_1694165114769' => $bitrixUser['id_orx']
            ]
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        if ($result['total'] == 0){
            Log::info("checkContactBitrix result is 0");
            $this->createContactBitrix($bitrixUser);
        } else {
            Log::info("checkContactBitrix result is more than 0");
            Log::info(["checkContactBitrixResult" => $result]);
        }

        return true;
    }

    public function createContactBitrix($bitrixUser){
        Log::info("createContactBitrix");

        $queryUrl = "https://orix.bitrix24.kz/rest/180/z61hnycx6b9254zm/crm.contact.add";
        $queryData = http_build_query(array(
            'fields' => [
                'NAME' => $bitrixUser['name'],
                'LAST_NAME' => $bitrixUser['surname'],
                'PHONE' => [ [ "VALUE"=> $bitrixUser['phone'], "VALUE_TYPE"=> "WORK" ] ],
                'EMAIL' => [ [ "VALUE"=> $bitrixUser['email'], "VALUE_TYPE"=> "WORK" ] ],
                'UF_CRM_1694165114769' => $bitrixUser['id_orx'],
                'UF_CRM_1694178304769' => $bitrixUser['id'],
                'SOURCE_ID' => 'WEB',
                'ASSIGNED_BY_ID' => 8
            ]
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);
        $newContactId = $result['result'];

        $queryUrl = "https://orix.bitrix24.kz/rest/180/z61hnycx6b9254zm/crm.deal.add";
        $queryData = http_build_query(array(
            'fields' => [
                'TITLE' => 'Новый пользователь на сайте',
                'CONTACT_ID' => $newContactId,
                'SOURCE_ID' => 'WEB',
                'ASSIGNED_BY_ID' => 8
            ]
        ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        Log::info(["createdUserBitrixId" => $newContactId, "createdUserDealBitrixId" => $result['result']]);
        return true;
    }

}
