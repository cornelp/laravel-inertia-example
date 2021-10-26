<?php

use App\Enums\CarReviewType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->date('date');
            $table->date('invoice_date');
            $table->unsignedTinyInteger('type_id')->default(CarReviewType::REPARATION);
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('amount');
            $table->string('observations')->nullable();
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
        Schema::dropIfExists('car_reviews');
    }
}
