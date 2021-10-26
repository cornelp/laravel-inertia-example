<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('liters');
            $table->integer('consumption')->default(0);
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
        Schema::dropIfExists('fuels');
    }
}
