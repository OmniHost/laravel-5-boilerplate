<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RadiostationNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//
		Schema::create('radiostation_notifications', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('contest_id');
			$table->string('subject', 191);
			$table->mediumText('body');
			$table->timestamp('schedule')->nullable();
			$table->string('initials', 10)->nullable();
			$table->string('suburb')->nullable();
			$table->boolean('is_sms')->default(1);
			$table->boolean('running');
			$table->boolean('completed');
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('contest_id')->references('id')->on('radiostation_contests');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		//
		Schema::dropIfExists('radiostation_notifications');
    }
}
