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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->float('price'); //Phí dịch vụ
            $table->tinyInteger('health_insurance_applied')->default(0);//Có áp dụng giảm phí cho bệnh nhân có bhyt không (mặc định là không)
            $table->float('health_insurance_value')->default(0);//Với trường hợp áp dụng thì áp dụng bao nhiêu %. Mặc định là 0%
            $table->text('detail')->nullable();//Lưu thông tin các chỉ số riêng của từng dịch vụ
            //vd dịch vụ là xét nghiệm máu {{keyword: RBC, name: "Số lượng hồng cầu", reference_range: "74-110", unit: "mg/dL"}, {keyword: wbc, name: "Số lượng bạch cầu", reference_range: ">130", unit: "g/dL"}, ..}
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('service_catalogue_id');
            $table->foreign('service_catalogue_id')->references('id')->on('service_catalogues');
            $table->unsignedBigInteger('room_catalogue_id');
            $table->foreign('room_catalogue_id')->references('id')->on('room_catalogues');
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
        Schema::dropIfExists('services');
    }
};
