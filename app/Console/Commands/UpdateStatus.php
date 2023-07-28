<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Parcel;
use GuzzleHttp\Client;


class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron Start");
        $allParcels = Parcel::where('integration_id', '!=', null)->where(function ($q) {
            $q->where('status', 0)->orWhere('status', 1)->orWhere('status', 2);
        })->get();
        foreach ($allParcels as $parcel) {
            $status = $this->findDealById($parcel['integration_id'])['result']['data']['deal']['status'];
//            Log::info(["dealId " => $parcel['integration_id'], 'status ' => $status]);
            if ($status == 'in_sender_filial') {
                Log::info(["dealId " => $parcel['integration_id'], 'status ' => $status]);
                $parcel['status'] = 1;
                $parcel->update();
                Log::info(['updatedStatus' => $parcel['status']]);
            } else if ($status == 'packing') {
                Log::info(["dealId " => $parcel['integration_id'], 'status ' => $status]);
                $parcel['status'] = 2;
                $parcel->update();
                Log::info(['updatedStatus' => $parcel['status']]);
            } else if ($status == 'sent_to_client') {
                Log::info(["dealId " => $parcel['integration_id'], 'status ' => $status]);
                $parcel['status'] = 3;
                $parcel->update();
                Log::info(['updatedStatus' => $parcel['status']]);
            }

        }
        Log::info('Cron End');
    }

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

    private function findDealById($dealId)
    {
        $endPoint = '/account/partnerApi/showDeal/' . $dealId;

//        $queryParams = [
//            'deal_id' => $dealId
//        ];

        $data = $this->requestBuilder($endPoint);
        $client = new Client();
        return json_decode($client->get(
            $data['uri'],
            array(
                'headers' => $data['headers'],
//                'json' => $queryParams
            )
        )->getBody()->getContents(), true);
    }
}
