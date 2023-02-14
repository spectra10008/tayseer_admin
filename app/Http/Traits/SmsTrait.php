<?php
namespace App\Http\Traits;
use App\Jobs\CustomerStatusJob;
use App\Models\FormRequestSmsLog;
use App\Jobs\RefreshTokenJob;
use Carbon\Carbon;
use Auth;

trait SmsTrait {
    public function send_msg($phone, $sms_content,$request_id)
    {
        $curl = curl_init();

        $from = "Tjoint";
        $to = '249'.intval($phone);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mazinhost.com/smsv1/sms/api",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "action=send-sms&api_key=VGpvaW50OmFobWVkMTMwNA==&to=$to&from=$from&sms=$sms_content&unicode=1",
        ));

        $response = curl_exec($curl);
        $result = json_decode($response,true);
        curl_close($curl);

        $new_log = new FormRequestSmsLog();
        $new_log->request_id = $request_id;
        $new_log->phone = $to;
        $new_log->content = $sms_content;
        $new_log->status = $result['code'];
        $new_log->send_at = Carbon::now();
        $new_log->sended_by  = Auth::id();
        $new_log->save();
    }
}
