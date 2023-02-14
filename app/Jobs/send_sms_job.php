<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\SmsTrait;

class send_sms_job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $request_info;
     public $sms_content;
    public function __construct($request_info,$sms_content)
    {
        $this->request_info = $request_info;
        $this->sms_content = $sms_content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->send_msg($this->request_info->phone,$this->sms_content,$this->request_info->id);
    }
}
