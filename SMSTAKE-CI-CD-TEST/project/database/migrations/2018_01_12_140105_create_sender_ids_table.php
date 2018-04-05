<?php

use App\SMS\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::TblSenderId, function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_name',6);
            $table->tinyInteger('status')->default('1')
                                         ->comment("1.Waiting for Approval 2.Assigned 3.Approved 4.Rejected");
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists(DBTable::TblSenderId);
    }
}
