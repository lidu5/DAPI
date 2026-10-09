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
        Schema::create('software_digital_health_intervention', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('software_id');
            $table->foreign('software_id')->references('id')->on('software')->onDelete('cascade');

            $table->unsignedBigInteger('digital_health_intervention_id');
            $table->foreign('digital_health_intervention_id', 'fk_b7a7cb978e')->references('id')->on('digital_health_interventions')->onDelete('cascade');
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
        Schema::dropIfExists('software_digital_health_intervention');
    }
};
