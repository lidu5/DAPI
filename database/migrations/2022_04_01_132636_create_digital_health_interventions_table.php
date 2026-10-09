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
        Schema::create('digital_health_interventions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['PERSON', 'HEALTHCARE PROVIDERS', 'HEALTH MANAGEMENT AND SUPPORT PERSONNEL', 'DATA SERVICES']);
            $table->string('category');
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
        Schema::dropIfExists('digital_health_interventions');
    }
};
