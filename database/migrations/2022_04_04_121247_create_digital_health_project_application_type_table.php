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
        Schema::create('digital_health_project_application_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_7d5b645f35')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('application_type_id');
            $table->foreign('application_type_id', 'fk_5a523701c5')->references('id')->on('application_types')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_project_application_type');
    }
};
