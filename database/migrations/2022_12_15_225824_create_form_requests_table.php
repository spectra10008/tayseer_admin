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
        Schema::create('form_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone');
            $table->string('email');
            $table->string('age');
            $table->string('id_number');
            $table->foreignId('social_situation_id')->constrained('social_situations')->nullable();
            $table->integer('children_no')->default(0);
            $table->string('address');
            $table->string('location_on_map')->nullable();
            $table->boolean('is_bank_account')->default(0);
            $table->foreignId('bank_id')->constrained('banks')->nullable();
            $table->string('branch_name')->nullable();
            $table->integer('account_no')->nullable();
            $table->integer('funding_status')->default(0);
            $table->string('project_name');
            $table->foreignId('project_sector_id')->constrained('sectors');
            $table->foreignId('fund_type_id')->constrained('fund_types');
            $table->string('project_fund_need');
            $table->longText('project_desc');
            $table->longText('notes')->nullable();
            $table->string('feasibility_study_file');
            $table->string('personal_image');
            $table->string('id_file');
            $table->foreignId('status_id')->constrained('form_request_statuses')->default(1);
            $table->foreignId('mfi_provider_id')->constrained('mfi_providers')->nullable();
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
        Schema::dropIfExists('form_requests');
    }
};
