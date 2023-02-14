<?php
namespace App\Http\Traits;
use App\Jobs\CustomerStatusJob;
use App\Models\WebConfig;
use App\Jobs\RefreshTokenJob;
use Carbon\Carbon;

trait ApiTrait {
    public function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }


    public function dispatch_refresh_job()
    {
        $web_config = WebConfig::first();
        $on = Carbon::now()->addSeconds($web_config->refresh_period);
        RefreshTokenJob::dispatch()->delay($on);
    }
}
