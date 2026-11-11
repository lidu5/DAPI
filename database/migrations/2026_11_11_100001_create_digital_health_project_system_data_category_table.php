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
        Schema::create('digital_health_project_system_data_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->foreign('digital_health_project_id', 'fk_dhp_sys_data_cat_project')
                  ->references('id')->on('digital_health_projects')->onDelete('cascade');

            $table->unsignedBigInteger('system_data_category_id');
            $table->foreign('system_data_category_id', 'fk_dhp_sys_data_cat_category')
                  ->references('id')->on('system_data_categories')->onDelete('cascade');
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
        Schema::dropIfExists('digital_health_project_system_data_category');
    }
};
