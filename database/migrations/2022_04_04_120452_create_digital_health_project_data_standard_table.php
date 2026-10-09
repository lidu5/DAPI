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
        Schema::create('digital_health_project_data_standard', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_8672ae0149')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('data_standard_id');
            $table->foreign('data_standard_id')->references('id')->on('data_standards')->onDelete('cascade');

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
        Schema::dropIfExists('digital_health_project_data_standard');
    }
};
