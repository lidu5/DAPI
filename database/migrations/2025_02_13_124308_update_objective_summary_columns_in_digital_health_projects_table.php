<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE digital_health_projects MODIFY objective TEXT NOT NULL');
        DB::statement('ALTER TABLE digital_health_projects MODIFY summary TEXT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE digital_health_projects MODIFY objective VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE digital_health_projects MODIFY summary VARCHAR(255)');

    }
};

