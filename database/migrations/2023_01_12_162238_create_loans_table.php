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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_no')->unique();
            $table->foreignId('request_id')->constrained('form_requests');
            $table->foreignId('product_id')->constrained('loan_products');
            $table->foreignId('status_id')->constrained('loan_statuses');
            $table->string('loan_amount');
            $table->timestamp('released_date');
            $table->string('loan_interest');
            $table->string('loan_interest_per');
            $table->string('loan_duration');
            $table->string('loan_duration_per');
            $table->string('description')->nullable();
            $table->string('loan_file')->nullable();
            $table->foreignId('loan_manager')->constrained('users');
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
        Schema::dropIfExists('loans');
    }
};
