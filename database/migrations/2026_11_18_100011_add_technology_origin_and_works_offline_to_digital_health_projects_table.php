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
            $table->enum('technology_origin', [
                'Built bespoke',
                'Commercial off-the-shelf product',
                'Open-source product, configured',
                'Built on a DPI building block (e.g. OpenG2P, ODK)',
            ])->nullable()->after('sends_data_to_other_systems');
            $table->enum('works_offline', ['Yes, fully', 'Partially', 'No'])
                  ->nullable()->after('technology_origin');
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
            $table->dropColumn(['technology_origin', 'works_offline']);
        });
    }
};
