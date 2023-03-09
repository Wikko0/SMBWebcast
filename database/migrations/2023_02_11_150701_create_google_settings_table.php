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
        Schema::create('google_settings', function (Blueprint $table) {
            $table->id();
            $table->string('google_client_id');
            $table->string('google_client_secret');
            $table->string('spreadsheet');
            $table->string('sheet_name');
            $table->string('service_account');
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
        Schema::dropIfExists('google_settings');
    }
};
