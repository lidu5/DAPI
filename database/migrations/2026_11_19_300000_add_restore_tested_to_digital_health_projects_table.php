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
            $table->enum('restore_tested', [
                'Yes, within the last 12 months',
                'Yes, more than 12 months ago',
                'Never',
            ])->nullable()->after('backup_location');
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
            $table->dropColumn('restore_tested');
        });
    }
};
