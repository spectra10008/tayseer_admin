<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_request_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('form_requests');
            $table->string('phone');
            $table->text('content');
            $table->boolean('status')->default(0);
            $table->string('send_at');
            $table->foreignId('sended_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_request_sms_logs');
    }
};
