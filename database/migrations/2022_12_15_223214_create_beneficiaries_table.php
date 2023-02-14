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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone');
            $table->string('email');
            $table->string('age');
            $table->string('id_number');
            $table->foreignId('social_situation_id')->constrained('social_situations')->nullable();
            $table->boolean('is_grouped')->default(0);
            $table->integer('children_no')->default(0);
            $table->string('address');
            $table->string('location_on_map');
            $table->boolean('is_bank_account')->default(0);
            $table->foreignId('bank_id')->constrained('banks')->nullable();
            $table->string('branch_name')->nullable();
            $table->integer('account_no')->nullable();
            $table->integer('funding_status')->default(0);
            $table->string('image');
            $table->string('id_image');
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
        Schema::dropIfExists('beneficiaries');
    }
};
