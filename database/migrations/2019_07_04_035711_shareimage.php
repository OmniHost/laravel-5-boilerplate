<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Shareimage extends Migration
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
			$table->integer('shareimage1')->nullable();
			$table->integer('shareimage2')->nullable();
			$table->integer('shareimage3')->nullable();
			$table->integer('shareimage4')->nullable();
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
			$table->dropColumn('shareimage1');
			$table->dropColumn('shareimage2');
			$table->dropColumn('shareimage3');
			$table->dropColumn('shareimage4');
		});
    }
}
