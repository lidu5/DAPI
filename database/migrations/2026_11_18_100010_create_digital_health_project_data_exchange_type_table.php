<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('digital_health_project_data_exchange_type');
        Schema::create('digital_health_project_data_exchange_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('digital_health_project_id');
            $table->unsignedBigInteger('data_exchange_type_id');
            $table->timestamps();

            $table->foreign('digital_health_project_id', 'dhp_data_exchange_type_project_id_fk')
                  ->references('id')->on('digital_health_projects')->onDelete('cascade');
            $table->foreign('data_exchange_type_id', 'dhp_data_exchange_type_type_id_fk')
                  ->references('id')->on('data_exchange_types')->onDelete('cascade');
        });

        // Carry over existing single-select values into the new pivot table
        DB::table('digital_health_project_data_exchange_type')->insertUsing(
            ['digital_health_project_id', 'data_exchange_type_id', 'created_at', 'updated_at'],
            DB::table('digital_health_projects')
                ->selectRaw('id, data_exchange_type_id, NOW(), NOW()')
                ->whereNotNull('data_exchange_type_id')
        );

        Schema::table('digital_health_projects', function (Blueprint $table) {
            $table->dropForeign(['data_exchange_type_id']);
            $table->dropColumn('data_exchange_type_id');
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
            $table->unsignedBigInteger('data_exchange_type_id')->nullable()->after('sends_data_to');
            $table->foreign('data_exchange_type_id')
                  ->references('id')->on('data_exchange_types')->onDelete('set null');
        });

        // Restore the first selected exchange type per project
        DB::statement('UPDATE digital_health_projects p
            SET p.data_exchange_type_id = (
                SELECT MIN(pivot.data_exchange_type_id)
                FROM digital_health_project_data_exchange_type pivot
                WHERE pivot.digital_health_project_id = p.id
            )');

        Schema::dropIfExists('digital_health_project_data_exchange_type');
    }
};
