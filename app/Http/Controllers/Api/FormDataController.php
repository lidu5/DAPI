<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\OrganizationUnit;
use App\Models\HealthProfessionalGroup;
use App\Models\Region;
use App\Models\Partner;
use App\Models\License;
use App\Models\ApplicationPlatform;
use App\Models\ProgrammingLanguage;
use App\Models\DbmsSupport;
use App\Models\OsSupport;
use App\Models\DataStandard;
use App\Models\EhaComponent;
use App\Models\ApplicationType;
use App\Models\HealthFocusArea;
use App\Models\HealthSystemChallenge;
use App\Models\OwnershipType;
use App\Models\DeploymentLocation;
use App\Models\DigitalHealthIntervention;
use App\Models\FacilityType;
use App\Models\OSIApprovedLicense;

use App\Laravue\Models\Role;

class FormDataController extends Controller
{
    //
    public function getRegistrationData(Request $request){
        $response = new \stdClass();

        if (isset($request->type)){
            if(str_contains($request->type, 'works')){
                $response->works = OrganizationUnit::get();
            } 
            if(str_contains($request->type, 'licenses')){
                $response->licenses = License::get();              
            }
            if(str_contains($request->type, 'applications')){
                $response->applications = ApplicationPlatform::get();           
            }
            if(str_contains($request->type, 'languages')){
                $response->languages = ProgrammingLanguage::get();            
            }
            if(str_contains($request->type, 'oses')){
                $response->oses = OsSupport::get();         
            }
            if(str_contains($request->type, 'dbms')){
                $response->dbms = DbmsSupport::get();        
            }
            if(str_contains($request->type, 'standard')){
                $response->standard = DataStandard::get();            
            }
            if(str_contains($request->type, 'component')){
                $response->component = EhaComponent::get();        
            }
            if(str_contains($request->type, 'application_type')){
                $response->application_type = ApplicationType::get();        
            }
            if(str_contains($request->type, 'focus_areas')){
                $response->focus_areas = HealthFocusArea::get();
            }
            if(str_contains($request->type, 'challenges')){
                $response->challenges = HealthSystemChallenge::get();          
            }
            if(str_contains($request->type, 'ownerships')){
                $response->ownerships = OwnershipType::get();           
            }
            if(str_contains($request->type, 'locations')){
                $response->locations = DeploymentLocation::get();            
            }
            if(str_contains($request->type, 'regions')){
                $response->regions = Region::get();          
            }
            if(str_contains($request->type, 'interventions')){
                $response->interventions = DigitalHealthIntervention::get();
            }
            if(str_contains($request->type, 'professions')){
                $response->professions = HealthProfessionalGroup::get();
            }
            if(str_contains($request->type, 'facility_types')){
                $response->facility_types = FacilityType::get();
            }
            if(str_contains($request->type, 'osi_licenses')){
                $response->osi_licenses = OSIApprovedLicense::get();
            }
            if(str_contains($request->type, 'roles')){
                $response->roles = Role::get();
            }

        } else {
            $response->roles = Role::where('name', '!=', 'admin')->get();
            $response->works = OrganizationUnit::get();
            $response->professions = HealthProfessionalGroup::get();
            $response->addresses = Region::where('name', '!=', 'National')->get();
        }
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function getProjectSearchData(Request $request){
        $response = [
            'organizations' => OrganizationUnit::get(),
            'regions' => Region::get(),
            'components' => EhaComponent::get(),
            'application_types' => ApplicationType::get(),
            'focus_areas' => HealthFocusArea::get(),
            'challenges' => HealthSystemChallenge::get(),
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
