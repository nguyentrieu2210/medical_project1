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
        Schema::create('medical_orders', function (Blueprint $table) {
            $table->id();
            $table->text('detail');//Chi tiết y lệnh 
            //vd 1 chi tiết y lệnh như {{type: "medication", name: "Thuốc Panadol", measure: "Viên", dosage:"2 viên"}, {type:"service", name:"Xét nghiệm máu"}}
            $table->text('note');//Ghi chú của bác sĩ
            $table->unsignedBigInteger('treament_session_id');
            $table->foreign('treament_session_id')->references('id')->on('treament_sessions'); // 1 đợt điều trị sẽ có thể có nhiều y lệnh 
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
        Schema::dropIfExists('medical_orders');
    }
};
