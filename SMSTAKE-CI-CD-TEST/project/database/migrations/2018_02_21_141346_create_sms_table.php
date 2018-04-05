<?php

use App\SMS\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DBTable::TblSms, function (Blueprint $table) {
                $table->increments('id');
                $table->text('text_message');
                $table->integer('language')->comment('1)English2)Unicode');
                $table->boolean('is_schedule');
                $table->dateTime('date_scheduled')->nullable();
                $table->integer('user_id')->unsigned()->comment('uploaded by');
                $table->integer('sender_id')->unsigned();
                $table->enum('status', ['W', 'P', 'C', 'S'])->default('W')->comment('W-Waiting, P-Pending, C-Completed, S-Stopped');
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users');
                $table->foreign('sender_id')
                      ->references('id')
                      ->on(DBTable::TblSenderId);
                $table->integer('credit')
                      ->default('0')
                      ->comment('how many credit does it take');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(DBTable::TblSms);
    }
}
