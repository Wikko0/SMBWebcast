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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('meeting_id');
            $table->string('created_by');
            $table->string('created_by_mail');
            $table->string('password')->nullable();
            $table->string('joined')->default(1);
            $table->string('app_id');
            $table->boolean('microphone')->nullable();
            $table->boolean('desktop')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
};
