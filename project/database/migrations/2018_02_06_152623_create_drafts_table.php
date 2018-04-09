<?php

use App\SMS\Constants\Common;
use App\SMS\Constants\DBTable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            DBTable::TblDraft, function (Blueprint $table) {
            $table->increments('id');
            $table->text('draft_message')->charset('utf8')->collate('utf8_general_ci');
            $table->integer('user_id')->unsigned()->nullable();
            $table->enum('draft_type', Common::DB_LANGUAGES)->default('en');
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
        Schema::dropIfExists(DBTable::TblDraft);
    }
}
