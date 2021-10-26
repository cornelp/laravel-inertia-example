<?php

use App\Enums\DebtDetailType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debt_id');
            $table->string('notes')->nullable();
            $table->string('number');
            $table->date('date');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('paid_from_bank')->nullable();
            $table->unsignedTinyInteger('type')->default(DebtDetailType::INVOICE);
            $table->string('second_note')->nullable();
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
        Schema::dropIfExists('debt_details');
    }
}
