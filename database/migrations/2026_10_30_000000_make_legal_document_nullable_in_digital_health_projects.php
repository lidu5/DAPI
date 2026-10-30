<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN legal_document DROP NOT NULL');
    }

    public function down(): void
    {
        DB::statement('UPDATE digital_health_projects SET legal_document = \'\' WHERE legal_document IS NULL');
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN legal_document SET NOT NULL');
    }
};
