<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ApplicationPlatformSeeder::class);
        $this->call(DataStandardSeeder::class);
        $this->call(DbmsSupportSeeder::class);
        $this->call(DeploymentLocationSeeder::class);
        $this->call(DigitalHealthInterventionSeeder::class);
        $this->call(EhaComponentSeeder::class);
        $this->call(HealthFocusAreaSeeder::class);
        $this->call(HealthProfessionalSeeder::class);
        $this->call(HealthSystemChallengesSeeder::class);
        $this->call(LicenseSeeder::class);
        $this->call(OrganizationUnitSeeder::class);
        $this->call(OsSupportSeeder::class);
        $this->call(OwnershipTypeSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(ProgrammingLanguageSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(EvaluationMetricsCategorySeeder::class);
        $this->call(EvaluationMetricsSeeder::class);
        $this->call(FacilityTypeSeeder::class);
        $this->call(OSIApprovedLicenseSeeder::class);
        $this->call(ApplicationTypeSeeder::class);
    

    }
}
