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
        Schema::create('medical_record_service', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('medical_record_id');
            $table->foreign('medical_record_id')->references('id')->on('medical_records');//Mỗi lần bệnh nhân đi khám có thể thực hiện nhiều dịch vụ cận lâm sàng
            $table->string('service_name', 255);
            $table->text('result_details');//Kết quả kiểm tra của bệnh nhân (vd: xét nghiệm máu)
            //vd dịch vụ là xét nghiệm máu {{keyword: RBC, name: "Số lượng hồng cầu", reference_range: "74-110", result: 111, unit: "mg/dL"}, {keyword: wbc, name: "Số lượng bạch cầu", reference_range: "<130", result: 120, unit: "g/dL"}, ..}
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
        Schema::dropIfExists('medical_record_service');
    }
};
