<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN objective TYPE TEXT');
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN summary TYPE TEXT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN objective TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE digital_health_projects ALTER COLUMN summary TYPE VARCHAR(255)');

    }
};

