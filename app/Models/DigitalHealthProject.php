<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Laravue\Models\User;

class DigitalHealthProject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['uuid', 'name', 'start_date', 'contact_name', 'contact_email', 'contact_phone', 'budget', 'objective', 'legal_document', 'organization_unit_id', 'user_id', 'is_registered', 'keywords', 'project_website_link', 'category_of_evidence', 'publications', 'funding_sources', 'business_model', 'key_challenges_recommendations', 'views'
    ];

    public function organization_unit(){
        return $this->belongsTo(OrganizationUnit::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function license(){
        return $this->belongsTo(License::class);
    }

    public function osi_licenses(){
        return $this->belongsToMany(OSIApprovedLicense::class, 'digital_health_projects_o_s_i_approved_licenses');
    }

    public function applications(){
        return $this->belongsToMany(ApplicationPlatform::class, 'digital_health_project_application_platform');
    }

    public function operating_systems(){
        return $this->belongsToMany(OsSupport::class, 'digital_health_project_os_support');
    }

    public function tech_stacks(){
        return $this->belongsToMany(ProgrammingLanguage::class, 'digital_health_project_programming_language');
    }

    public function languages(){
        return $this->tech_stacks()->where('type', 'Language');
    }

    public function frameworks(){
        return $this->tech_stacks()->where('type', 'Framework');
    }

    public function databases(){
        return $this->belongsToMany(DbmsSupport::class, 'digital_health_project_dbms_support');
    }

    public function standards(){
        return $this->belongsToMany(DataStandard::class, 'digital_health_project_data_standard');
    }

    public function components(){
        return $this->belongsToMany(EhaComponent::class, 'digital_health_project_eha_component');
    }

    public function focus_areas(){
        return $this->belongsToMany(HealthFocusArea::class, 'digital_health_project_health_focus_area');
    }

    public function challenges(){
        return $this->belongsToMany(HealthSystemChallenge::class, 'digital_health_project_health_system_challenge');
    }

    public function partners(){
        return $this->belongsToMany(OrganizationUnit::class, 'digital_health_project_partner');
    }

    public function implementing_partners(){
        return $this->belongsToMany(OrganizationUnit::class, 'digital_health_project_implementing_partner');
    }

    public function ownership_type(){
        return $this->belongsToMany(OwnershipType::class, 'digital_health_project_ownership_type');
    }

    public function deployment_locations(){
        return $this->belongsToMany(DeploymentLocation::class, 'digital_health_project_deployment_location');
    }

    public function coverages(){
        return $this->belongsToMany(Region::class, 'digital_health_project_coverage')
            ->withPivot('num_hw_users', 'num_hw_facilities', 'num_clients');
    }

    public function implement_locations(){
        return $this->belongsToMany(DeploymentLocation::class, 'digital_health_project_implementation_location');
    }

    public function data_collected_locations(){
        return $this->belongsToMany(DeploymentLocation::class, 'digital_health_project_collected_from');
    }

    public function targeted_users(){
        return $this->belongsToMany(HealthProfessionalGroup::class, 'digital_health_project_health_professional_group');
    }
    public function application_types()
    {
        return $this->belongsToMany(ApplicationType::class, 'digital_health_project_application_type');
    }

    public function activities(){
        return $this->hasMany(Software::class);
    }

    public function softwares(){
        return $this->activities()->with('interventions');
    }

    public function resources(){
        return $this->hasMany(DigitalHealthProjectResource::class);
    }

    public function evaluations(){
        return $this->belongsToMany(EvaluationMetrics::class, 'digital_health_projects_evaluations')
            ->withPivot('score');
    }
    public function decline_messages(){
        return $this->belongsToMany(User::class, 'project_evaluation_message')
            ->withPivot('message', 'type');
    }
    public function geographic_scope(){
        return $this->belongsToMany(Region::class, 'digital_health_project_geographic_scope');
    }
    public function facility_types(){
        return $this->belongsToMany(FacilityType::class, 'digital_health_project_facility_type');
    }
    public function certificates(){
        return $this->hasMany(DHSCertificate::class, 'digital_health_project_id');
    }
}
