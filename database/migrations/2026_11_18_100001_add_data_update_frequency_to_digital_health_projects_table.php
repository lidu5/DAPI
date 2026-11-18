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
            $table->unsignedBigInteger('data_update_frequency_id')->nullable()->after('data_is_sent_to_moh');
            $table->foreign('data_update_frequency_id')
                  ->references('id')->on('data_update_frequencies')->onDelete('set null');
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
            $table->dropForeign(['data_update_frequency_id']);
            $table->dropColumn('data_update_frequency_id');
        });
    }
};
