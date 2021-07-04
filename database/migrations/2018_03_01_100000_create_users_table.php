<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name',50);
            $table->char('phone_number',11)->unique();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->boolean('active')->default(true);
            $table->string('level')->default('user');
            $table->boolean('vip_user')->default(false);
            $table->dateTime('vip_time_of_expire')->nullable();
            $table->mediumInteger('points')->default(0);
            $table->char('shaba_number',26)->nullable();
            $table->char('bank_card_number',16)->nullable();
            $table->unsignedSmallInteger('count_of_managing_lottery')->default(0);
            $table->unsignedSmallInteger('count_of_membering_lottery')->default(0);
            $table->string('avatar_url')->nullable();
            $table->decimal('cash',15,0)->default(0);
            $table->string('two_factor_auth',30)->default('off');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
