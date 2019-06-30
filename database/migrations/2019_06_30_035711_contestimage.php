<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contestimage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//
		Schema::table('radiostation_contests', function($table) {
			$table->integer('image1')->nullable();
			$table->integer('image2')->nullable();
			$table->integer('image3')->nullable();
			$table->integer('image4')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('radiostation_contests', function($table) {
			$table->dropColumn('image1');
			$table->dropColumn('image2');
			$table->dropColumn('image3');
			$table->dropColumn('image4');
		});
    }
}
