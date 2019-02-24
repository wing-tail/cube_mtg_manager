<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtg_cube_card_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('printed');
            $table->unsignedTinyInteger('type');
            $table->json('details')->nullable();
            $table->index(['name', 'printed', 'type']);
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
        Schema::dropIfExists('card_list');
    }
}
