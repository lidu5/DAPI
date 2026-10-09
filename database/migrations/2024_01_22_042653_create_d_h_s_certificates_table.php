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
        Schema::create('d_h_s_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_health_project_id')
                  ->constrained();
            $table->enum('type', ['REGISTRATION', 'COMPETENCE']);
            $table->date('certify_date');
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->unique(['digital_health_project_id', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_h_s_certificates');
    }
};
