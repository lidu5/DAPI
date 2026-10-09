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
        Schema::create('digital_health_project_collected_from', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_1f5ac488c2')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('deployment_location_id');
            $table->foreign('deployment_location_id', 'fk_d6a62c1483')->references('id')->on('deployment_locations')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_project_collected_from');
    }
};
