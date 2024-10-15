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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('birthday');
            $table->string('address', 255);
            $table->string('phone', 20)->nullable();
            $table->string('cccd_number', 20);
            $table->string('health_insurance_code', 25)->nullable();
            $table->string('guardian_phone', 20)->nullable();
            $table->tinyInteger('gender');//1 - nam, 2 - nữ, 3 - giới tính khác
            $table->string('keyword', 50)->unique();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
