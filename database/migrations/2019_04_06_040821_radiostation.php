<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Radiostation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//
		Schema::create('radiostations', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('slug');
			$table->string('logo')->nullable();
			$table->string('color-primary')->nullable();
			$table->string('color-secondary')->nullable();
			$table->string('color-tertiary')->nullable();
			$table->string('header')->nullable();
			$table->string('tagline')->nullable();
			$table->timestamps();
        });

		Schema::create('radiostation_users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('radiostation_id');

			$table->foreign('user_id')
			->references('id')
			->on(config('access.table_names.users'));

			$table->foreign('radiostation_id')
			->references('id')
			->on('radiostations');

			$table->boolean('administrator');
			$table->timestamps();
		});

		Schema::create('radiostation_contests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('slug');
			$table->text('message')->nullable();
			$table->integer('upload_id')->nullable();
			$table->dateTime('start');
			$table->dateTime('end');
			$table->boolean('enabled');
			$table->boolean('unique_entrants');
			$table->unsignedBigInteger('radiostation_id');
			$table->softDeletes();
			$table->timestamps();
			$table->foreign('radiostation_id')->references('id')->on('radiostations');
		});

		Schema::create('radiostation_entrants', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->uuid('uuid');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('email')->nullable();
			$table->string('mobile');
			$table->string('recording');
			$table->string('recording_url')->nullable();
			$table->boolean('completed');
			$table->boolean('optin');
			$table->unsignedBigInteger('radiostation_contests_id');
			$table->ipAddress('ipaddress');
			$table->softDeletes();
			$table->foreign('radiostation_contests_id')->references('id')->on('radiostation_contests');
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
		//
		Schema::dropIfExists('radiostations');
		Schema::dropIfExists('radiostation_user');
		Schema::dropIfExists('radiostation_contests');
		Schema::dropIfExists('radiostation_entrants');
    }
}
