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
        Schema::dropIfExists('digital_health_project_system_language');
        Schema::create('digital_health_project_system_language', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->unsignedBigInteger('system_language_id');
            $table->timestamps();

            $table->foreign('digital_health_project_id', 'dhp_system_language_project_id_fk')
                  ->references('id')->on('digital_health_projects')->onDelete('cascade');
            $table->foreign('system_language_id', 'dhp_system_language_language_id_fk')
                  ->references('id')->on('system_languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_health_project_system_language');
    }
};
