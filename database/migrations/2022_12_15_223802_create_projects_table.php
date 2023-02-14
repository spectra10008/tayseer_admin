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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->text('image');
            $table->text('desc');
            $table->string('address');
            $table->string('location');
            $table->foreignId('sector_id')->constrained('sectors');
            $table->longText('need');
            $table->string('start_date')->nullable();
            $table->enum('status', ['running', 'not_working' ,'no_start_yet']);
            $table->string('fund_amount_need_sdg');
            $table->string('fund_amount_need_usd')->default(0);
            $table->string('fund_amount_taken_sdg')->default(0);
            $table->string('fund_amount_taken_usd')->default(0);
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
