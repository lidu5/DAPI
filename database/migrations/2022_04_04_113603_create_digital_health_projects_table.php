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
        Schema::create('digital_health_projects', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('objective');
            $table->double('budget');
            $table->string('legal_document');
            $table->string('summary')->nullable();

            $table->date('golive_date')->nullable();
            $table->text('government_office')->nullable();
            $table->string('documentation_link')->nullable();
            $table->string('wiki_page_link')->nullable();
            $table->string('git_link')->nullable();
            $table->text('other_typeof_applications')->nullable();
            $table->text('other_operating_systems')->nullable();
            $table->text('other_databases')->nullable();
            $table->text('other_frameworks')->nullable();
            $table->text('third_party_tools')->nullable();
            
            $table->boolean('fhir_compliant')->nullable();
            $table->boolean('has_api_support')->nullable();
            $table->boolean('is_api_published')->nullable();
            $table->boolean('is_openapi')->nullable();
            $table->string('api_documentation_link')->nullable();
            $table->boolean('data_is_sent_to_moh')->nullable();

            $table->string('moh_contribution')->nullable();
            $table->enum('dhs_implemeted', ['Public', 'Private'])->nullable();
            $table->string('current_status')->nullable();
            $table->string('current_version')->nullable();
            $table->string('national_scopes')->nullable();
            
            $table->string('logo')->nullable();
            $table->string('bandwidth')->nullable();
            $table->string('maintenance_support_provider')->nullable();
            $table->boolean('has_impact_evaluation')->nullable();
            $table->string('impact_evaluation')->nullable();

            $table->string('status')->default('new');
            $table->boolean('isRegistered')->default(false);
            $table->date('published_date')->nullable();
            $table->boolean('retire')->default(false);            
            
            $table->foreignId('organization_unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('license_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('digital_health_projects');
    }
};
