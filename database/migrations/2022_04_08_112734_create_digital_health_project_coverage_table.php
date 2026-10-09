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
        Schema::create('digital_health_project_coverage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'ref36')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->integer('num_hw_users')->nullable();
            $table->integer('num_hw_facilities')->nullable();
            $table->integer('num_clients')->nullable();

            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id', 'ref37')->references('id')->on('regions')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_project_coverage');
    }
};
