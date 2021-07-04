<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lottery_manager_id')->constrained();

            $table->decimal('amount',15,0);
            $table->dateTime('time_of_first_lot');
            $table->string('cycle',30);
            $table->unsignedSmallInteger('count_of_lots');
            $table->string('type_of_income',30);
            $table->string('name');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->unsignedInteger('count_of_view')->default(0);
            $table->unsignedInteger('count_of_like')->default(0);
            $table->string('type_of_choose_winner',30);
            $table->string('status',30)->default('در حال عضوگیری');

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
        Schema::dropIfExists('lotteries');
    }
}
