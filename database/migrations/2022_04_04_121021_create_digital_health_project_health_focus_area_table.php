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
        Schema::create('digital_health_project_health_focus_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_8bdd70c09a')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('health_focus_area_id');
            $table->foreign('health_focus_area_id', 'fk_2529bc93cd')->references('id')->on('health_focus_areas')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_project_health_focus_area');
    }
};
