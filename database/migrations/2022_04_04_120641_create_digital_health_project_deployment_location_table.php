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
        Schema::create('digital_health_project_deployment_location', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_330c504e32')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('deployment_location_id');
            $table->foreign('deployment_location_id', 'fk_ef3f6405cf')->references('id')->on('deployment_locations')->onDelete('cascade');
            
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
        Schema::dropIfExists('digital_health_project_deployment_location');
    }
};
