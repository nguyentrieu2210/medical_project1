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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->tinyInteger('status_active')->default(1);//1- phòng đang hoạt động, 0-bị dừng hoạt động
            $table->integer('total_bed')->default(0); //Số giường có trong phòng
            $table->tinyInteger('status_bed')->default(0);//Trạng thái giường của phòng (0 - chưa đầy, 1 - đầy)
            $table->unsignedBigInteger('room_catalogue_id');
            $table->foreign('room_catalogue_id')->references('id')->on('room_catalogues');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('rooms');
    }
};
