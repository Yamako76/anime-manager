<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_anime_relation_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('folder_anime_relation_id');
            $table->bigInteger('user_id');
            $table->bigInteger('folder_id');
            $table->bigInteger('anime_id');
            $table->string('status', 15);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_anime_relation_histories');
    }
};
