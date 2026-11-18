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
        Schema::table('digital_health_projects', function (Blueprint $table) {
            $table->boolean('receives_data_from_other_systems')->nullable()->after('data_exchange_type_id');
            $table->boolean('sends_data_to_other_systems')->nullable()->after('receives_data_from_other_systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_health_projects', function (Blueprint $table) {
            $table->dropColumn(['receives_data_from_other_systems', 'sends_data_to_other_systems']);
        });
    }
};
