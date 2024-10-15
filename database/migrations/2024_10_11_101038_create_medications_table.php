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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->float('price');
            $table->integer('measure_count');//Đây là số lượng tính theo đơn vị (ví dụ: 1 hộp thuốc có 30 viên nén hoặc 20 túi, ...)
            $table->string('measure', 25);//Đây là chỉ đơn vị (ví dụ: viên, túi, ...)
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('medication_catalogue_id');
            $table->foreign('medication_catalogue_id')->references('id')->on('medication_catalogues');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medications');
    }
};
