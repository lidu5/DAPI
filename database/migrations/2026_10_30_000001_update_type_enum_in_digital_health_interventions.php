<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE digital_health_interventions DROP CONSTRAINT IF EXISTS digital_health_interventions_type_check');
            DB::statement("UPDATE digital_health_interventions SET type = 'Digital system'");
            DB::statement("ALTER TABLE digital_health_interventions ADD CONSTRAINT digital_health_interventions_type_check CHECK (type IN ('Digital system', 'Data service', 'Delivery channel', 'Equipment', 'Programme'))");
        } else {
            DB::statement("UPDATE digital_health_interventions SET type = 'Digital system'");
            DB::statement("ALTER TABLE digital_health_interventions MODIFY COLUMN type ENUM('Digital system', 'Data service', 'Delivery channel', 'Equipment', 'Programme') NOT NULL");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE digital_health_interventions DROP CONSTRAINT IF EXISTS digital_health_interventions_type_check');
            DB::statement("UPDATE digital_health_interventions SET type = 'DATA SERVICES'");
            DB::statement("ALTER TABLE digital_health_interventions ADD CONSTRAINT digital_health_interventions_type_check CHECK (type IN ('PERSON', 'HEALTHCARE PROVIDERS', 'HEALTH MANAGEMENT AND SUPPORT PERSONNEL', 'DATA SERVICES'))");
        } else {
            DB::statement("UPDATE digital_health_interventions SET type = 'DATA SERVICES'");
            DB::statement("ALTER TABLE digital_health_interventions MODIFY COLUMN type ENUM('PERSON', 'HEALTHCARE PROVIDERS', 'HEALTH MANAGEMENT AND SUPPORT PERSONNEL', 'DATA SERVICES') NOT NULL");
        }
    }
};
