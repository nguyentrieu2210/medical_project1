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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->foreign('bill_id')->references('id')->on('bills');//1 hóa đơn thì có nhiều chi tiết hóa đơn
            $table->unsignedBigInteger('model_id');
            $table->string('model_name', 255);
            $table->float('price');
            $table->tinyInteger('health_insurance_applied')->default(0);//có được áp dụng bảo hiểm y tế hay không
            $table->float('health_insurance_value')->default(0);
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
        Schema::dropIfExists('bill_details');
    }
};
