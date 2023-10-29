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
        Schema::create('mfi_form_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_request_id')->constrained('form_requests');
            $table->foreignId('mfi_provider_id')->constrained('mfi_providers');
            $table->longText('note');
            $table->boolean('status')->default(0);
            $table->foreignId('mfi_provider_user_id')->constrained('mfi_provider_users');
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
        Schema::dropIfExists('mfi_form_notes');
    }
};
