<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteryLotterymemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_lotterymember', function (Blueprint $table) {
            $table->foreignId('lottery_id')->constrained()->onDelete('cascade');
            $table->foreignId('lottery_member_id')->constrained()->onDelete('cascade');
            $table->primary(['lottery_id','lottery_member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_lotterymember');
    }
}
