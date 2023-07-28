<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Carbon\Carbon;

class GetCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $currency = Setting::where('code','currency')->first();
        if(!$currency) return;
        // echo now()->format('d.m.Y');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://nationalbank.kz/rss/get_rates.cfm?fdate='.now()->format('d.m.Y'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $xml = simplexml_load_string(curl_exec($ch));
        curl_close($ch);

        foreach ($xml->item as $item) {
            if((string)$item->title == 'USD')
                $currency->update(['value'=>(string)$item->description]);
        }

        //$xml = simplexml_load_string('https://nationalbank.kz/rss/get_rates.cfm?fdate='.now()->format('d.m.Y'));

    }
}
