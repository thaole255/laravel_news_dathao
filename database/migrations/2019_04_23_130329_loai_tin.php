<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoaiTin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LoaiTin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->interger('idLoaiTin');
            $table->string('Ten');
            $table->string('TenKhongDau');
            $table->timestamps();
            $table->foreign('idLoaiTin')->reference('id')->on('TheLoai');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LoaiTin');
    }
}
