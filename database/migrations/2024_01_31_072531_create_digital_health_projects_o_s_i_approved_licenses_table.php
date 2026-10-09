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
        Schema::create('digital_health_projects_o_s_i_approved_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_095ba8b094')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('o_s_i_approved_license_id');
            $table->foreign('o_s_i_approved_license_id', 'fk_5bdfe6f8e3')->references('id')->on('o_s_i_approved_licenses')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_projects_o_s_i_approved_licenses');
    }
};
