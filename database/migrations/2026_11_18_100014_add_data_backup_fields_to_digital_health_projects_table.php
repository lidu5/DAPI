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
            $table->enum('data_backup', [
                'Yes: automated',
                'Yes: manual',
                'No',
            ])->nullable()->after('works_offline');
            $table->enum('backup_frequency', [
                'Continuously',
                'Daily',
                'Weekly',
                'Monthly',
                'Ad hoc',
            ])->nullable()->after('data_backup');
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
            $table->dropColumn(['data_backup', 'backup_frequency']);
        });
    }
};
