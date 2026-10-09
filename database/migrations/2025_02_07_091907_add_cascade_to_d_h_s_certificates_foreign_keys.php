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
        Schema::table('d_h_s_certificates', function (Blueprint $table) {
            $table->dropForeign(['digital_health_project_id']);
            
            $table->foreign('digital_health_project_id')
                  ->references('id')
                  ->on('digital_health_projects')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_h_s_certificates', function (Blueprint $table) {
            $table->dropForeign(['digital_health_project_id']);
        });
    }
};
