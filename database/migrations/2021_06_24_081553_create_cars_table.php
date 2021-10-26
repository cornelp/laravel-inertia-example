<?php

use App\Enums\AreaType;
use App\Enums\CityType;
use App\Enums\FuelType;
use App\Enums\CarModelType;
use App\Enums\CarType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('area')->default(AreaType::BC);
            $table->unsignedTinyInteger('city')->default(CityType::BACAU);
            $table->string('license_no')->nullable();
            $table->unsignedTinyInteger('model')->default(CarModelType::DACIA_LOGAN);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedTinyInteger('fuel')->default(FuelType::GAS);
            $table->unsignedMediumInteger('production_year');
            $table->unsignedMediumInteger('purchase_year')->default(2021);
            $table->unsignedTinyInteger('type')->default(CarType::CAR);
            $table->unsignedMediumInteger('engine_capacity')->default(1000);
            $table->unsignedMediumInteger('revision_in_km')->nullable();
            $table->unsignedTinyInteger('horse_power')->nullable();
            $table->string('chassis');
            $table->date('insurance_till_date')->nullable();
            $table->date('road_tax_till_date')->nullable();
            $table->date('tehnical_inspection_till_date')->nullable();
            $table->string('fuel_card')->nullable();
            $table->string('fuel_pin')->nullable();
            $table->integer('consumption')->nullable();
            $table->boolean('needs_road_tax')->default(0);
            $table->unsignedTinyInteger('distribution_in_years')->default(2);
            $table->unsignedMediumInteger('distribution_in_km')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('cars');
    }
}
