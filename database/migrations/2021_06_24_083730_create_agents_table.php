<?php

use App\Enums\AreaType;
use App\Enums\CorType;
use App\Enums\PositionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('contract_no');
            $table->string('name');
            $table->unsignedTinyInteger('area')->default(AreaType::BC);
            $table->date('hire_date');
            $table->date('birth_date');
            $table->string('cnp');
            $table->string('ic_serial');
            $table->unsignedInteger('ic_number');
            $table->string('address');
            $table->string('ic_city');
            $table->unsignedTinyInteger('position')->default(PositionType::FILLER);
            $table->unsignedTinyInteger('cor')->default(CorType::FILLER);
            $table->date('resignation_date')->nullable();
            $table->unsignedInteger('phone_id')->nullable();
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
        Schema::dropIfExists('agents');
    }
}
