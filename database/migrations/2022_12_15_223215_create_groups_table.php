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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->string('group_address');
            $table->string('group_contact');
            $table->boolean('is_registered')->default(0);
            $table->foreignId('group_leader_id')->constrained('beneficiaries')->nullable();
            $table->foreignId('register_type_id')->constrained('group_register_types')->nullable();
            $table->string('foundation_certificate')->nullable();
            $table->boolean('is_bank_account')->default(0);
            $table->foreignId('bank_id')->constrained('banks')->nullable();
            $table->string('branch_name')->nullable();
            $table->integer('account_no')->nullable();
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
        Schema::dropIfExists('groups');
    }
};
