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
            $table->string('keywords')->nullable(false)->default('digital health');
            $table->string('project_website_link')->nullable();
            $table->string('category_of_evidence')->nullable(false)->default('No evidence');;
            $table->text('publications')->nullable();
            $table->string('funding_sources')->nullable(false)->default('Donors');;
            $table->string('business_model')->nullable();
            $table->text('key_challenges_recommendations')->nullable();
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
            $table->dropColumn([
                'keywords',
                'project_website_link',
                'category_of_evidence',
                'publications',
                'funding_sources',
                'business_model',
                'key_challenges_recommendations',
            ]);
        });
    }
};
