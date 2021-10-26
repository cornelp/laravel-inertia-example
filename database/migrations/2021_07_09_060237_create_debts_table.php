<?php

use App\Enums\AreaType;
use App\Enums\CityType;
use App\Enums\DebtType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('area')->default(AreaType::BC);
            $table->unsignedMediumInteger('city')->default(CityType::BACAU);
            $table->string('name');
            $table->integer('balance')->default(0);
            $table->integer('invoiced_amount')->default(0);
            $table->integer('paid_amount')->default(0);
            $table->string('notes')->nullable();
            $table->string('tax_code')->unique();
            $table->string('bank_account')->unique();
            $table->string('bank');
            $table->boolean('is_active')->default(1);
            $table->unsignedSmallInteger('type')->default(DebtType::RENT);
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
        Schema::dropIfExists('debts');
    }
}
