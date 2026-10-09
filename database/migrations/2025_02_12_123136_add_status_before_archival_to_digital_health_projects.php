<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('digital_health_projects', function (Blueprint $table) {
            $table->string('status_before_archival')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('digital_health_projects', function (Blueprint $table) {
            $table->dropColumn('status_before_archival');
        });
    }
};
