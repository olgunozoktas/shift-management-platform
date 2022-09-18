<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->datetime('date_time');
            $table->enum('type', ['day', 'evening', 'night']);
            $table->unsignedBigInteger('job_role_id');
            $table->foreign('job_role_id')->references('id')->on('job_roles');
            $table->longText('text')->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->foreign('assigned_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('shifts');
    }
};
