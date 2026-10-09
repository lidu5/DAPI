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
        Schema::create('digital_health_projects_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'ref45')->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('evaluation_metrics_id');
            $table->foreign('evaluation_metrics_id', 'ref46')->references('id')->on('evaluation_metrics')->onDelete('cascade');

        $table->integer('score')                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ;
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
        Schema::dropIfExists('digital_health_projects_evaluations');
    }
};
