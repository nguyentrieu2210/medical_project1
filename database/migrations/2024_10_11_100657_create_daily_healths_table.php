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
        Schema::create('daily_healths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treament_session_id');
            $table->foreign('treament_session_id')->references('id')->on('treament_sessions'); // 1 đợt điều trị sẽ có thể sẽ kiểm tra sức khỏe thường xuyên
            $table->dateTime('check_date');//Thời gian kiểm tra
            $table->float('temperature')->default(37);//Nhiệt độ cơ thể
            $table->string('blood_pressure', 10);//Huyết áp: (vd: 120/80)
            $table->integer('heart_rate');//Nhịp tim (số nhịp mỗi phút)
            $table->text('note')->nullable();//Các triệu chứng hoặc ghi chú bổ sung
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
        Schema::dropIfExists('daily_healths');
    }
};
