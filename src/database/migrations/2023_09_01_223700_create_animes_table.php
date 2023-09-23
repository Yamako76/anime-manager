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
        Schema::create('animes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('name', 500)->unique();
            $table->string('memo', 500)->nullable();
            $table->string('status', 15);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('latest_changed_at');
            $table->timestamps();

            $table->unique(['user_id', 'name'], 'unique_animes_01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animes');
    }
};
