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
        Schema::create('medical_record_medication', function (Blueprint $table) {
            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')->references('id')->on('medical_records');
            $table->unsignedBigInteger('medication_id');
            $table->foreign('medication_id')->references('id')->on('medications');
            $table->string('name', 255);//Tên thuốc (ở đây dù đã lưu id của thuốc nhưng vẫn lưu tên thuốc với mục đích hạn chế số lần join bảng)
            $table->string('dosage', 255);//Liều lượng (ví dụ: 60 viên )
            $table->string('measure', 25);//đơn vị (ví dụ: viên, gói, ống)
            $table->text('description');//Ghi chú của bác sĩ về cách sử dụng thuốc (ví dụ: "Ngày uống 3 lần, mỗi lần 1 viên")
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
        Schema::dropIfExists('medical_record_medication');
    }
};
