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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('user_id');//Bác sĩ thăm khám
            $table->dateTime('visit_date');//Ngày khám
            $table->text('diagnosis'); //Chuẩn đoán
            $table->text('notes'); //Ghi chú của bác sĩ
            $table->date('apointment_date')->nullable();//Ngày hẹn khám
            $table->tinyInteger('is_inpatient')->default(0);//Có điều trị nội trú không, mặc định là 0 - ngoại trú (1 - nội trú)
            $table->text('inpatient_detail')->nullable();//Thông tin chi tiết hơn của điều trị nối trú (ví dụ như ngày nhập viện, ra viện, tiền ứng trước cho bệnh viện)
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
        Schema::dropIfExists('medical_records');
    }
};
