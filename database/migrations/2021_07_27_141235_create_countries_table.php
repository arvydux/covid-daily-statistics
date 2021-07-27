<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->integer('new_confirmed')->default(0);;
            $table->integer('total_confirmed')->default(0);;
            $table->integer('new_deaths')->default(0);;
            $table->integer('total_deaths')->default(0);;
            $table->integer('new_recovered')->default(0);;
            $table->integer('total_recovered')->default(0);;
            $table->dateTimeTz('date');
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
        Schema::dropIfExists('countries');
    }
}
