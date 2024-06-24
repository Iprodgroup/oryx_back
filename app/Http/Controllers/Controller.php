<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail;
use App\Models\Notification;
use App\Models\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendNotifiaction($user, $type = '',  $title = '', $text = '')
    {
        if (!$type) {
            Notification::create(['user_id'=>$user->id, 'title'=>$title, 'text'=>$text]);
        } else {
            if (in_array($type, ['regp','usa','delivered','balance','bonus'])) {
                if($user->setting('disable')) return;
                if(!$user->setting($type,0)) return;
            }

            $notif = Setting::where('code',$type)->where('type',1)->where('active',1)->first();
            if ($notif) {
                Notification::create(['user_id'=>$user->id, 'title'=>$notif->name, 'text'=>$this->rep($notif->value,$title)]);
            }
            $mail = Setting::where('code',$type)->where('type',0)->where('active',1)->first();
            if ($mail) {
                    Mail::send('emails.notification', ['text' => $this->rep($mail->value,$title)], function ($m) use ($user,$mail) {
                        $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                        $m->to($user->email, $user->name)->subject($mail->name);
                    });
            }
        }

    }

    private function rep($o, $arr){
        if(!is_array($arr)) return $o;

        foreach ($arr as $key => $value) {
            if(!is_array($value))
                $o = str_replace('{'.$key.'}', $value, $o);
        }
        return $o;
    }
}
