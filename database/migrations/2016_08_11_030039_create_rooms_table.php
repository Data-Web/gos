<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');

            // Main room information
            $table->string('code', 11)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('description', 200)->nullable();
            $table->text('organizational')->nullable();
            $table->string('manager', 50)->nullable();
            $table->unsignedSmallInteger('member')->nullable();
            $table->dateTime('founding');
            $table->timestamps();

            // Indexes or unique
            $table->unique('code');
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
