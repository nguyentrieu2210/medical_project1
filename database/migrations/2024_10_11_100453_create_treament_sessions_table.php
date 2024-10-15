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
        Schema::create('treament_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')->references('id')->on('medical_records'); //1 bệnh án có thể có từ 0 đến nhiều đợt điều trị nội trú (0 trong trường hợp khám ngoại trú)
            $table->unsignedBigInteger('department_id');//mã khoa
            $table->unsignedBigInteger('room_id');//mã giường
            $table->unsignedBigInteger('bed_id');//mã giường
            $table->unsignedBigInteger('user_id');//bác sĩ phụ trách điều trị 
            $table->dateTime('admission_date');//Ngày nhập viện tại khoa
            $table->dateTime('discharge_date');//Ngày xuất viện tại khoa (chuyển khoa)
            $table->text('diagnosis');//Chuẩn đoán (Kết luận của bác sĩ khám bệnh)
            $table->tinyInteger('status')->default(1);//1 - đang điều trị (0 - Đã kết thúc đợt điều trị (có thể là được xuất viện hoặc chuyển khoa)) 
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
        Schema::dropIfExists('treament_sessions');
    }
};
