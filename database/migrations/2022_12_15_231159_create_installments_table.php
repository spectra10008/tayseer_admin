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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_receipt_number');
            $table->string('deserved_amount');
            $table->string('amount_paid')->nullable();
            $table->enum('payment_type', ['cash', 'e-payment'])->nullable();
            $table->string('date_payment_installment');
            $table->string('date_amount_paid')->nullable();
            $table->foreignId('status_id')->constrained('installment_statuses');
            $table->enum('status', ['pending', 'confirmed']);
            $table->string('receipt_file')->nullable();
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
        Schema::dropIfExists('installments');
    }
};
