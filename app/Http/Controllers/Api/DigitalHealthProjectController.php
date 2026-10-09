<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use App\Laravue\Acl;

use App\Models\DigitalHealthProject;
use App\Models\OrganizationUnit;
use App\Models\License;
use App\Models\ApplicationPlatform;
use App\Models\OsSupport;
use App\Models\ProgrammingLanguage;
use App\Models\DbmsSupport;
use App\Models\DataStandard;
use App\Models\EhaComponent;
use App\Models\HealthFocusArea;
use App\Models\HealthSystemChallenge;
use App\Models\FacilityType;
use App\Models\OwnershipType;
use App\Models\DeploymentLocation;
use App\Models\Region;
use App\Models\Software;
use App\Models\DigitalHealthIntervention;
use App\Models\DigitalHealthProjectResource;
use App\Models\HealthProfessionalGroup;
use App\Models\Partner;
use App\Models\OSIApprovedLicense;
use App\Models\ActivityLog;
use App\Models\ApplicationType;


use App\Http\Resources\DigitalHealthProjectBasicResource;
use App\Http\Resources\DigitalHealthProjectResourcesResource;
use App\Http\Resources\DigitalHealthProjectFullResource;

use Illuminate\Support\Facades\Auth;

class DigitalHealthProjectController extends Controller
{
    const ITEM_PER_PAGE = 15;

    const NEW_PROJECT = "new";
    const REQUEST_REGISTRATION = "request registration";
    const APPROVED_REGISTRATION = "registration approved";
    const REQUEST_CERT_COMPETENCE = "request cert competence";
    const CERT_COMPETENCE = "cert competence";
    const REJECTED_REGISTRATION = "registration rejected";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $searchParams = $request->all();
        $typeQuery = DigitalHealthProject::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');
        $status = Arr::get($searchParams, 'status', '');
        $statuses = Arr::get($searchParams, 'statuses', []);

        $organization = Arr::get($searchParams, 'organization', '');
        $application_type = Arr::get($searchParams, 'application_type', '');
        $focus_area = Arr::get($searchParams, 'focus_area', '');
        $region = Arr::get($searchParams, 'region', '');
        $challenge = Arr::get($searchParams, 'challenge', '');
        $component = Arr::get($searchParams, 'component', '');
        $dhs_implemeted = Arr::get($searchParams, 'dhs_implemeted', '');

        if (!empty($status)) {

            if($status === 'request registration') {
                $typeQuery->where('status', $status)
                          ->orWhere('status', 'request_cert_registration');
            } else {
                $typeQuery->where('status', $status);
            }
        }

            if (!empty($keyword)) {
            $typeQuery->where(function ($query) use ($keyword) {
                $query->where('name', 'ilike', '%' . $keyword . '%')
                      ->orWhere('keywords', 'ilike', '%' . $keyword . '%');
            });
        }

        if(!(Auth::user()->hasRole(Acl::ROLE_ADMIN) || Auth::user()->hasRole(Acl::ROLE_QA_APPROVER)
            || Auth::user()->hasRole(Acl::ROLE_REG_APPROVER))){
            $typeQuery->where('user_id', Auth::user()->id);
        }

        if(Auth::user()->hasRole(Acl::ROLE_QA_APPROVER) || Auth::user()->hasRole(Acl::ROLE_REG_APPROVER) || Auth::user()->hasRole(Acl::ROLE_ADMIN)){
            if(!empty($statuses)){
                $typeQuery->where('status', $statuses[0])->orWhere('status', $statuses[1]);

                if(!empty($statuses[2])){
                    $typeQuery->orWhere('status', $statuses[2]);
                }
            }            
        }

        if (!empty($focus_area)) {
            $typeQuery->whereHas('focus_areas', function($q) use ($focus_area) {
                $q->where('health_focus_area_id', $focus_area);
            });
        }

        if (!empty($region)) {
            $typeQuery->whereHas('coverages', function($q) use ($region) {
                $q->where('region_id', $region);
            });
        }

        if (!empty($challenge)) {
            $typeQuery->whereHas('challenges', function($q) use ($challenge) {
                $q->where('health_system_challenge_id', $challenge);
            });
        }

        if (!empty($component)) {
            $typeQuery->whereHas('components', function($q) use ($component) {
                $q->where('eha_component_id', $component);
            });
        }

        if (!empty($organization)) {
            $typeQuery->whereHas('organization_unit', function($q) use ($organization) {
                $q->where('id', $organization);
            });
        }
        if (!empty($application_type)) {
            $typeQuery->whereHas('application_types', function($q) use ($application_type) {
                $q->where('application_type_id', $application_type);
            });
        }

        if (!empty($dhs_implemeted)){
            $typeQuery->where('dhs_implemeted', $dhs_implemeted);
        }

        return DigitalHealthProjectBasicResource::collection($typeQuery->orderBy('updated_at', 'desc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $params = $request->all();
        try{
            $request->validate([
            'api_documentation_link' => 'nullable|string|max:255',
            'current_version' => 'nullable|string|max:255',
            'activity' => 'nullable|array',
            'activity.name' => 'required_with:activity|string|max:255',
            'activity.description' => 'required_with:activity|string|max:255', 
            'activity.dhi'=>'required_with:activity|array|min:1'
            ], [
                'api_documentation_link.max' => 'The API documentation link is too long. Please enter a link with a maximum of 255 characters.',
                'current_version.max' => 'The current version is too long. Please enter a maximum of 255 characters.',
                'activity.name.required_with' => 'The activity name is required when an activity is provided.',
                'activity.name.max' => 'The activity name must not exceed 255 characters.',
                'activity.description.required_with' => 'The activity description is required when an activity is provided.',
                'activity.description.max' => 'The activity description must not exceed 255 characters.',
                'activity.dhi.required_with'=> 'Please select at least one Digital Health Intervention.',
            ]);

            if(isset($params["id"]) && !empty($params["id"]) && $params["id"] != "undefined"){

                $project = DigitalHealthProject::find($params["id"]);
                
                if(isset($params["name"])  && !empty($params["name"])){
                    $project->name = $params["name"];
                }
                if(isset($params["start_date"])  && !empty($params["start_date"])){
                    $project->start_date = $params["start_date"];
                }
                if(isset($params["contact_name"])  && !empty($params["contact_name"])){
                    $project->contact_name = $params["contact_name"];
                }
                if(isset($params["contact_email"])  && !empty($params["contact_email"])){
                    $project->contact_email = $params["contact_email"];
                }
                if(isset($params["contact_phone"])  && !empty($params["contact_phone"])){
                    $project->contact_phone = $params["contact_phone"];
                }
                if(isset($params["objective"])  && !empty($params["objective"])){
                    $project->objective = $params["objective"];
                }
                if(isset($params["budget"])  && !empty($params["budget"])){
                    $project->budget = $params["budget"];
                }
                if(isset($params["lead_organization"])  && !empty($params["lead_organization"])){
                    $project->organization_unit_id = $params["lead_organization"];
                }
                if(isset($params["keywords"])  && !empty($params["keywords"])){
                    $project->keywords = $params["keywords"];
                }
                if(isset($params["data_legal_document_file"])){
                    if(!empty($project->legal_document)){
                        $existFile = 'storage/legal_doc/'.$project->legal_document;
                        if(file_exists($existFile)){
                            unlink($existFile);
                        }
                    }
                    
                    $fileName = $this->uploadLegalDocument($params['data_legal_document_file']);

                    if ($fileName == null){
                        return response()->json("Uploading legal document error. Please contact Administrator or try later!", 500);
                    }

                    $project->legal_document = $fileName;
                }
                $project->save();
                ActivityLog::create([
                    'type' => 'DHS updated',
                    'remarks' => sprintf('%s(%d) has been updated',$project->name, $project->id),
                    'model' => 'DigitalHealthProject',
                    'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
                ]);

            } else {
                if (DigitalHealthProject::where('name', $params['name'])->exists()){
                    return response()->json($params['name']." already exists. Please use another name or edit from the Project section.", 500);
                }

                if(!isset($params["data_legal_document_file"])){
                    return response()->json("Document file required", 500);
                }               
                
                $fileName = $this->uploadLegalDocument($params['data_legal_document_file']);
                if ($fileName == null){
                    return response()->json("Uploading legal document error. Please contact Administrator or try later!", 500);
                }

                $project = DigitalHealthProject::create([
                    'uuid' => Str::uuid()->toString(),
                    'name' => $params['name'],
                    'start_date' => $params['start_date'],
                    'keywords' => $params['keywords'],
                    'contact_name' => $params['contact_name'],
                    'contact_email' => $params['contact_email'],
                    'contact_phone' => $params['contact_phone'],
                    'budget' => $params['budget'],
                    'objective' => $params['objective'],
                    'legal_document' => $fileName,
                    'organization_unit_id' => $params["lead_organization"],
                    'user_id' => Auth::user()->id
                ]);


                ActivityLog::create([
                    'type' => 'DHS created',
                    'remarks' => sprintf('%s(%d) has been created',$project->name, $project->id),
                    'model' => 'DigitalHealthProject',
                    'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
                ]);
            }

            if(isset($params["data_partner"]) && !empty($params["data_partner"])){
                $project->partners()->detach();
                foreach(explode(",", $params["data_partner"]) as $partner){
                    $project->partners()->attach(OrganizationUnit::find($partner));
                }
          
            }

            if(isset($params["implementing_partners"]) && !empty($params["implementing_partners"])){
                $project->implementing_partners()->detach();
                foreach($params["implementing_partners"] as $implementing_partner){
                    $project->implementing_partners()->attach(OrganizationUnit::find($implementing_partner));
                }    
            }


            if(isset($params["project_website_link"]) && !empty($params["project_website_link"]) ){                
                $project->project_website_link = $params["project_website_link"];
            }

            if(isset($params["end_date"]) && !empty($params["end_date"]) && (bool)strtotime($params["end_date"])){                
                $project->end_date = $params["end_date"];
            }

            if(isset($params["summary"])){
                $project->summary = $params["summary"];
            }

            if(isset($params["golive_date"]) && !empty($params["golive_date"]) && (bool)strtotime($params["golive_date"])){
                $project->golive_date = $params["golive_date"];
            }

            if(isset($params["under_license"]) && !empty($params["under_license"])){
                $project->license_id = $params["under_license"];
            }

            if(isset($params["osi_license"]) && !empty($params["osi_license"])){
                $project->osi_licenses()->detach();
                foreach($params["osi_license"] as $osi_license){
                    $project->osi_licenses()->attach(OSIApprovedLicense::find($osi_license));
                }            
            }

            if(isset($params["ownership"]) && !empty($params["ownership"])){
                $project->ownership_type()->detach();
                $project->ownership_type()->attach(OwnershipType::find($params["ownership"]));
                
                if(isset($params["owner"]) && !empty($params["owner"])){
                    $project->government_office = $params["owner"];
                }
            }

            if(isset($params["documentation_link"]) && !empty($params["documentation_link"])){
                $project->documentation_link = $params["documentation_link"];
            }

            if(isset($params["wiki_page"]) && !empty($params["wiki_page"])){
                $project->wiki_page_link = $params["wiki_page"];
            }

            if(isset($params["git_link"]) && !empty($params["git_link"])){
                $project->git_link = $params["git_link"];
            }

            if(isset($params["application"]) && !empty($params["application"])){
                $project->applications()->detach();
                foreach($params["application"] as $application){
                    $project->applications()->attach(ApplicationPlatform::find($application));
                }

                if(isset($params["other_typeof_applications"]) && !empty($params["other_typeof_applications"])){
                    $project->other_typeof_applications = $params["other_typeof_applications"];
                }
            }

            if(isset($params["os"]) && !empty($params["os"])){
                $project->operating_systems()->detach();
                foreach($params["os"] as $os){
                    $project->operating_systems()->attach(OsSupport::find($os));
                }

                if(isset($params["other_operating_systems"]) && !empty($params["other_operating_systems"])){
                    $project->other_operating_systems = $params["other_operating_systems"];
                }
            }

            if(isset($params["language"]) && !empty($params["language"])){
                $project->tech_stacks()->detach($project->languages);
                foreach($params["language"] as $language){
                    $project->tech_stacks()->attach(ProgrammingLanguage::find($language));
                }
            }

            if(isset($params["framework"]) && !empty($params["framework"])){
                $project->tech_stacks()->detach($project->frameworks);
                foreach($params["framework"] as $framework){
                    $project->tech_stacks()->attach(ProgrammingLanguage::find($framework));
                }

                if(isset($params["other_frameworks"]) && !empty($params["other_frameworks"])){
                    $project->other_frameworks = $params["other_frameworks"];
                }
            }

            if(isset($params["db"]) && !empty($params["db"])){
                $project->databases()->detach();
                foreach($params["db"] as $db){
                    $project->databases()->attach(DbmsSupport::find($db));
                }

                if(isset($params["other_databases"]) && !empty($params["other_databases"])){
                    $project->other_databases = $params["other_databases"];
                }
            }

            if(isset($params["third_party_tools"]) && !empty($params["third_party_tools"])){
                $project->third_party_tools = $params["third_party_tools"];
            }

            if(isset($params["component"]) && !empty($params["component"])){
                $project->components()->detach();
                $project->components()->attach(EhaComponent::find($params["component"]));         
            }

            if(isset($params["application_type"]) && !empty($params["application_type"])){
                $project->application_types()->detach();
                $project->application_types()->attach(ApplicationType::find($params["application_type"]));         
            }

            if(isset($params["fhir_compliant"])){
                if (!empty($params["fhir_compliant"])){
                    $project->fhir_compliant = $params["fhir_compliant"];
                } else {
                    $project->fhir_compliant = 0;
                }
            }

            if(isset($params["standard"]) && !empty($params["standard"])){
                $project->standards()->detach();
                foreach($params["standard"] as $standard){
                    $project->standards()->attach(DataStandard::find($standard));
                }
            }

            if(isset($params["has_api_support"])){
                if (!empty($params["has_api_support"])){
                    $project->has_api_support = $params["has_api_support"];

                    if(isset($params["is_api_published"])){
                        if (!empty($params["is_api_published"])){
                            $project->is_api_published = $params["is_api_published"];

                            if(isset($params["is_openapi"])){
                                if (!empty($params["is_openapi"])){
                                    $project->is_openapi = $params["is_openapi"];
                                } else {
                                    $project->is_openapi = 0;
                                }
                            }

                            if(isset($params["api_documentation_link"]) && !empty($params["api_documentation_link"])){
                                $project->api_documentation_link = $params["api_documentation_link"];
                                if(strlen($params["api_documentation_link"])>255) {
                                    return response()->json(['error' => 'api_documentation_link must not exceed 255 characters.'], 400);
                                } else {
                                    $project->bandwidth = $params["api_documentation_link"];
                                }
                            }
                            
                        } else {
                            $project->is_api_published = 0;
                        }
                    }
                } else {
                    $project->has_api_support = 0;
                }
            }

            if(isset($params["data_is_sent_to_moh"])){
                if (!empty($params["data_is_sent_to_moh"])){
                    $project->data_is_sent_to_moh = $params["data_is_sent_to_moh"];
                } else {
                    $project->data_is_sent_to_moh = 0;
                }
            }

            if(isset($params["focus_area"]) && !empty($params["focus_area"])){
                $project->focus_areas()->detach();
                foreach($params["focus_area"] as $focus_area){
                    $project->focus_areas()->attach(HealthFocusArea::find($focus_area));
                }
            }

            if(isset($params["challenge"]) && !empty($params["challenge"])){
                $project->challenges()->detach();
                foreach($params["challenge"] as $challenge){
                    $project->challenges()->attach(HealthSystemChallenge::find($challenge));
                }            
            }
            if(isset($params["category_of_evidence"]) && !empty($params["category_of_evidence"]) ){                
                $project->category_of_evidence = $params["category_of_evidence"];
            }

            if(isset($params["publications"]) && !empty($params["publications"]) ){                
                $project->publications = $params["publications"];
            }

            if (isset($params['funding_sources'])) {
                $fundingSources = $params['funding_sources'];
                if (is_array($fundingSources)) {
                    if (
                        in_array('Other', $fundingSources) &&
                        isset($params['other_funding_sources']) &&
                        !empty($params['other_funding_sources'])
                    ) {
                        $key = array_search('Other', $fundingSources);
                        $fundingSources[$key] = $params['other_funding_sources'];
                    }
            
                    $project->funding_sources = implode(', ', $fundingSources);
                } else {
                    $project->funding_sources = $fundingSources; 
                }
            }
            if (isset($params['business_model'])) {
                $business_model = $params['business_model'];
                if (is_array($business_model)) {
                    if (
                        in_array('Other', $business_model) &&
                        isset($params['other_business_model']) &&
                        !empty($params['other_business_model'])
                    ) {
                        $key = array_search('Other', $business_model);
                        $business_model[$key] = $params['other_business_model'];
                    }
            
                    $project->business_model = implode(', ', $business_model);
                } else {
                    $project->business_model = $business_model; 
                }
            }
            
            if(isset($params["key_challenges_recommendations"]) && !empty($params["key_challenges_recommendations"]) ){                
                $project->key_challenges_recommendations = $params["key_challenges_recommendations"];
            }

            if(isset($params["moh_contribution"]) && !empty($params["moh_contribution"])){
                $project->moh_contribution = $params["moh_contribution"];
            }

            if(isset($params["dhs_implemeted"]) && !empty($params["dhs_implemeted"])){
                $project->dhs_implemeted = $params["dhs_implemeted"];
            }

            if(isset($params["current_status"]) && !empty($params["current_status"])){
                $project->current_status = $params["current_status"];
            }

            if(isset($params["current_version"]) && !empty($params["current_version"])){
                $project->current_version = $params["current_version"];
            }

            if(isset($params["deployment_location"]) && !empty($params["deployment_location"])){
                $project->deployment_locations()->detach();
                foreach($params["deployment_location"] as $deployment_location){
                    $project->deployment_locations()->attach(DeploymentLocation::find($deployment_location));
                }    
            }

            if(isset($params["geographic_scope"]) && !empty($params["geographic_scope"])){
                $project->geographic_scope()->detach();
                foreach($params["geographic_scope"] as $geographic_scope){
                    $project->geographic_scope()->attach(Region::find($geographic_scope));
                }
            }

            if(isset($params["national_scopes"]) && !empty($params["national_scopes"])){
                if (strlen($params["national_scopes"]) > 255) {
                    return response()->json(['error' => 'national_scopes must not exceed 255 characters.'], 400);
                }else {
                    $project->national_scopes = $params["national_scopes"];
                }

                  }
            if(isset($params["facility_type"]) && !empty($params["facility_type"])){
                $project->facility_types()->detach();
                foreach($params["facility_type"] as $facility_type){
                    $project->facility_types()->attach(FacilityType::find($facility_type));
                }        
            }

            if(isset($params["target_user"]) && !empty($params["target_user"])){
                $project->targeted_users()->detach();
                foreach($params["target_user"] as $target_users){
                    $project->targeted_users()->attach(HealthProfessionalGroup::find($target_users));
                }            
            }
             if(isset($params["coverage"]) && !empty($params["coverage"])){
                $coverage = $params["coverage"];
                $project->coverages()->detach(Region::find($coverage["region"]));
                $project->coverages()->attach(Region::find($coverage["region"]), 
                    array(
                        'num_hw_users' => $coverage["num_hw_users"],
                        // 'num_hw_facilities' => $coverage["num_hw_facilities"],
                        'num_clients' => $coverage["num_clients"],
                    ));
            }

            if(isset($params["activity"]) && !empty($params["activity"])){
                $activity = $params["activity"];

                $exits = $project->activities()->where('name', $activity["name"])->first();
                if(empty($exits)){
                    $software = Software::create([
                        'name' => $activity["name"],
                        'description' => $activity["description"],
                        'digital_health_project_id' => $project->id,
                    ]);
    
                    foreach($activity["dhi"] as $dhi){
                        $software->interventions()->attach(DigitalHealthIntervention::find($dhi));
                    }
                }
            }

            if (isset($params["bandwidth"]) && !empty($params["bandwidth"])) {
                if (strlen($params["bandwidth"]) > 255) {
                    return response()->json(['error' => 'Bandwidth must not exceed 255 characters.'], 400);
                } else {
                    $project->bandwidth = $params["bandwidth"];
                }
            }
            
            if(isset($params["supports"]) && !empty($params["supports"])){
                if(strlen($params["supports"])>255){
                    return response()->json(['error' => 'Maintenance and Support provider must not exceed 255 characters.'], 400);
                }else{
                    $project->maintenance_support_provider = $params["supports"];
                }
                      
            }

            if(isset($params["implement_location"]) && !empty($params["implement_location"])){
                $project->implement_locations()->detach();
                foreach($params["implement_location"] as $implement_location){
                    $project->implement_locations()->attach(DeploymentLocation::find($implement_location));
                }            
            }

            if(isset($params["data_collected_location"]) && !empty($params["data_collected_location"])){
                $project->data_collected_locations()->detach();
                foreach($params["data_collected_location"] as $data_collected_location){
                    $project->data_collected_locations()->attach(DeploymentLocation::find($data_collected_location));
                }            
            }

            if(isset($params["has_impact_evaluation"])){
                if (!empty($params["has_impact_evaluation"] == 1)){
                    $project->has_impact_evaluation = $params["has_impact_evaluation"];
                }else {
                    $project->has_impact_evaluation = 0;
                }
            }

            $project->save();

            return new DigitalHealthProjectFullResource($project);

        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function resource(DigitalHealthProject $project, Request $request){
        $resource = $request->all();
         try{
            if (!$request->hasFile('file')) {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }
            
            $exits = $project->resources()->where('title', $resource["title"])->first();
            if(empty($exits)){
                $file = $resource["file"];
                if(!$file){
                    return response()->json(['error' => 'No file'], 404);
                }
                $description = $resource["description"];
                if (strlen($description) > 255) {
                    return response()->json(['error' => 'The resource description must not exceed 255 characters.'], 400);
                }
                $sub_folder = date("F").date("Y");
                $location = 'storage/resource/'.$sub_folder;
                
                if(!file_exists($location)){
                    mkdir($location, 0755, true);
                }
                
                $fileName = time().'.'.$file->extension();

                $filePath = $file->move(public_path($location), $fileName);
                
                $attachment = DigitalHealthProjectResource::create([
                    'title' => $resource["title"],
                    'description' =>$description,
                    'file_name' => $sub_folder.'/'.$fileName,
                    'digital_health_project_id' => $project->id
                ]);

                ActivityLog::create([
                    'type' => 'Resource Upload',
                    'remarks' => sprintf('%s(%d) has been uploaded',$attachment->title, $attachment->id),
                    'model' => 'DigitalHealthProjectResource',
                    'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
                ]);
            }

            return new DigitalHealthProjectFullResource($project);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function logo(DigitalHealthProject $project, Request $request){
        $logo = $request->all();
        
        try{
            $file = $logo["file"];
            if(!$file){
                return response()->json(['error' => 'No file'], 404);
            }

            if ($file->getSize() / (1024 * 1024) > 10){
                return response()->json(['error' => 'File size shoud be less than 10 MB'], 500);
            }

            $sub_folder = date("F").date("Y");
            $location = 'storage/logo/'.$sub_folder;
            
            if(!file_exists($location)){
                mkdir($location, 0755, true);
            }
            
            $fileName = time().'.'.$file->extension();

            $filePath = $file->move(public_path($location), $fileName);

            if(!empty($project->logo)){
                $existLogo = 'storage/logo/'.$project->logo;
                if(file_exists($existLogo)){
                    unlink($existLogo);
                }
            }

            $project->logo = $sub_folder.'/'.$fileName;
            $project->save();
                

            return new DigitalHealthProjectFullResource($project);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json($exception.getMessage(), 500);
        }
    }

    public function impact_evaluation(DigitalHealthProject $project, Request $request){
        $impact_evaluation = $request->all();
        
        try{
            $file = $impact_evaluation["file"];
            if(!$file){
                return response()->json(['error' => 'No file'], 404);
            }
            if ($file->getSize() / (1024 * 1024) > 10){
                return response()->json(['error' => 'File size shoud be less than 10 MB'], 500);
            }

            $sub_folder = date("F").date("Y");
            $location = 'storage/impact_evaluation/'.$sub_folder;
            
            if(!file_exists($location)){
                mkdir($location, 0755, true);
            }
            
            $fileName = time().'.'.$file->extension();

            $filePath = $file->move(public_path($location), $fileName);

            if(!empty($project->impact_evaluation)){
                $existFile = 'storage/impact_evaluation/'.$project->impact_evaluation;
                if(file_exists($existFile)){
                    unlink($existFile);
                }
            }

            $project->impact_evaluation = $sub_folder.'/'.$fileName;
            $project->save();
                

            return new DigitalHealthProjectFullResource($project);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json($exception.getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DigitalHealthProject $project)
    {
        return new DigitalHealthProjectFullResource($project);
    }
    public function archive($id)
    {
        $project = DigitalHealthProject::find($id);
        if ($project) {
            $project->status_before_archival =  $project->status;
            $project->status = 'archived';
            $project->is_registered = false;
            $project->save();
            return response()->json(['message' => 'Project archived successfully!'], 200);
        }
        return response()->json(['message' => 'Project not found!'], 404);
    }
    public function unarchive($id)
    {
        $project = DigitalHealthProject::find($id);
        if ($project) {
            $project->status = $project->status_before_archival; 
            $project->status_before_archival = '';
            if ($project->status === static::REQUEST_REGISTRATION || $project->status === static::NEW_PROJECT ||$project->status === static::REJECTED_REGISTRATION) {
                $project->is_registered = false;
            } else {
                $project->is_registered = true;
            }
            $project->save();
            return response()->json(['message' => 'Project unarchived successfully!'], 200);
        }
        return response()->json(['message' => 'Project not found!'], 404);
    }
    
    public function request_registration(DigitalHealthProject $project){
        if(empty($project->name)){            
        return response()->json("DHS name required for registration ", 500);
        }        
        if(empty($project->organization_unit)){
        return response()->json("DHS lead organization required for registration ", 500);
        }
        if(empty($project->start_date)){
        return response()->json("DHS start date required for registration ", 500);
        }
        if(empty($project->keywords)){
        return response()->json("DHS keywords are required for registration ", 500);
        }
        if(empty($project->contact_name)){
        return response()->json("DHS contact name required for registration ", 500);
        }
        if(empty($project->contact_email)){
        return response()->json("DHS contact email required for registration ", 500);
        }
        if(empty($project->contact_phone)){
        return response()->json("DHS contact phone required for registration ", 500);
        }
        if(empty($project->objective)){
        return response()->json("DHS objective required for registration ", 500);
        }
        if(empty($project->legal_document)){
        return response()->json("DHS legal document required for registration ", 500);
        }
        if(empty($project->license)){
        return response()->json("DHS license required for registration ", 500);
        }
        if(empty($project->osi_licenses)){
        return response()->json("DHS OSI license required for registration ", 500);
        }
        if(empty($project->ownership_type)){
        return response()->json("DHS ownership required for registration ", 500);
        }
        if(empty($project->applications)){
        return response()->json("DHS application type required for registration ", 500);
        }
        if(empty($project->operating_systems)){
        return response()->json("DHS operating system required for registration ", 500);
        }
        if(empty($project->tech_stacks)){
        return response()->json("DHS programming language/framework required for registration ", 500);
        }
        if(empty($project->databases)){
        return response()->json("DHS database required for registration ", 500);
        }
        if(empty($project->components)){
        return response()->json("DHS eHA component required for registration ", 500);
        }
        if(empty($project->application_types)){
        return response()->json("DHS application type required for registration ", 500);
        }
        if($project->fhir_compliant != 0 && $project->fhir_compliant != 1){
        return response()->json("DHS FHIR compliant required for registration ", 500);
        }
        if(empty($project->standards)){
        return response()->json("DHS standards required for registration ", 500);
        }
        if(empty($project->focus_areas)){
        return response()->json("DHS focus areas required for registration ", 500);
        }
        if(empty($project->category_of_evidence)){
            return response()->json("DHS category of evidence required for registration ", 500);
        }
        if(empty($project->funding_sources)){
        return response()->json("DHS funding sources required for registration ", 500);
        }
        if(empty($project->challenges)){
        return response()->json("DHS challenges required for registration ", 500);
        }
        if(empty($project->dhs_implemeted)){
        return response()->json("DHS implemented location required for registration ", 500);
        }
        if(empty($project->current_version)){
        return response()->json("DHS current version required for registration ", 500);
        }
        if(empty($project->deployment_locations)){
        return response()->json("DHS deployment location required for registration ", 500);
        }
        if(empty($project->resources)){
        return response()->json("DHS proof of safety document required for registration ", 500);
        }
        $project->status = static::REQUEST_REGISTRATION;
        $project->save();

        ActivityLog::create([
            'type' => 'REG Request',
            'remarks' => sprintf('%s(%d) requested for registration.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return new DigitalHealthProjectFullResource($project);
    }

    public function withdraw_registration(DigitalHealthProject $project){
        $project->status = static::NEW_PROJECT;
        $project->save();

        ActivityLog::create([
            'type' => 'WITHDRAW REG Request',
            'remarks' => sprintf('%s(%d) withdrawed registration request.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return new DigitalHealthProjectFullResource($project);
    }

    public function request_cert_comp(DigitalHealthProject $project){
        $project->status = static::REQUEST_CERT_COMPETENCE;
        $project->save();

        ActivityLog::create([
            'type' => 'CERT COMP Request',
            'remarks' => sprintf('%s(%d) requested for competence certificate.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return new DigitalHealthProjectFullResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DigitalHealthProject $project)
    {
        //
        try {
            $project->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }

    public function delete_type(DigitalHealthProject $project, Request $request){
        if($request->type == 'COVERAGE'){
            $project->coverages()->detach($request->id);
        }
        else if($request->type == 'ACTIVITY'){
            $project->activities()->find($request->id)->delete();
        }
        else if($request->type == 'RESOURCE'){
            $resource = $project->resources()->find($request->id);
            $exists = 'storage/resource/'.$resource->file_name;
            if(file_exists($exists)){
                unlink($exists);
            }        
            $resource->delete();
        }

        ActivityLog::create([
            'type' => 'Type Remove',
            'remarks' => sprintf('%s is removed for %s(%d) DHS.',$request->type, $project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return new DigitalHealthProjectFullResource($project);
    }

    public function search(Request $request)
    {
        $searchParams = $request->all();

        $typeQuery = DigitalHealthProject::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        $organization = Arr::get($searchParams, 'organization', '');
        $focus_area = Arr::get($searchParams, 'focus_area', []);
        $region = Arr::get($searchParams, 'region', '');
        $challenge = Arr::get($searchParams, 'challenge', '');
        $component = Arr::get($searchParams, 'component', '');
        $application_type = Arr::get($searchParams, 'application_type', '');
        $sortBy = Arr::get($searchParams, 'sort_by', 'updated_at_desc'); // Default sorting
        $sortOrder = in_array($sortBy, ['name_asc', 'date_oldest', 'start_date_oldest', 'updated_at_asc']) ? 'asc' : 'desc';

        $typeQuery->where(function ($query) use ($searchParams) {
            $query->where(function ($statusQuery) use ($searchParams) {
                $statusQuery->where('is_registered', true);
            });
            if (!empty($searchParams['keyword'])) {
                $query->where(function ($q) use ($searchParams) {
                    $q->where('name', 'ilike', '%' . $searchParams['keyword'] . '%')
                      ->orWhere('keywords', 'ilike', '%' . $searchParams['keyword'] . '%');
                });
            }        
            if (!empty($searchParams['focus_area'])) {
                $query->whereHas('focus_areas', function($q) use ($searchParams) {
                    $q->whereIn('health_focus_area_id', $searchParams['focus_area']);
                });
            }
            if (!empty($searchParams['region'])) {
                $query->whereHas('coverages', function($q) use ($searchParams) {
                    $q->whereIn('region_id', $searchParams['region']);
                });
            }
        
            if (!empty($searchParams['challenge'])) {
                $query->whereHas('challenges', function($q) use ($searchParams) {
                    $q->whereIn('health_system_challenge_id', $searchParams['challenge']);
                });
            }
        
            if (!empty($searchParams['component'])) {
                $query->whereHas('components', function($q) use ($searchParams) {
                    $q->whereIn('eha_component_id', $searchParams['component']);
                });
            }
        
            if (!empty($searchParams['application_type'])) {
                $query->whereHas('application_types', function($q) use ($searchParams) {
                    $q->whereIn('application_type_id', $searchParams['application_type']);
                });
            }
        
            if (!empty($searchParams['organization'])) {
                $query->whereHas('organization_unit', function($q) use ($searchParams) {
                    $q->whereIn('organization_units.id', $searchParams['organization']);
                });
            }
            });
    // **Sorting Logic**
    switch ($sortBy) {
        case 'name_asc':
            $typeQuery->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $typeQuery->orderBy('name', 'desc');
            break;
        case 'date_newest':
            $typeQuery->orderBy('created_at', 'desc');
            break;
        case 'date_oldest':
            $typeQuery->orderBy('created_at', 'asc');
            break;
        case 'start_date_newest':
            $typeQuery->orderBy('start_date', 'desc');
            break;
        case 'start_date_oldest':
            $typeQuery->orderBy('start_date', 'asc');
            break;
        default:
            $typeQuery->orderBy('updated_at', 'desc'); // Default sorting
            break;
    }
            
        return DigitalHealthProjectFullResource::collection(
        $typeQuery->paginate($limit)
        );
    }
    
    public function getProjectWithUuid(Request $request)
    {
        $project = DigitalHealthProject::where(function($query){
                $query->where('is_registered', true);
            })->where('uuid', $request->uuid)->first();
        $project->increment('views');

        return new DigitalHealthProjectFullResource($project);
    }

    private function uploadLegalDocument($file){
        try {
            if (!$file instanceof \Illuminate\Http\UploadedFile) {
                return $file; 
            }
    
            if ($file->getSize() / (1024 * 1024) > 10) {
                \Log::error('Legal document upload failed: File exceeds 10MB limit');
                return null;
            }
    
            $sub_folder = date("F").date("Y");
            $fileName = time().'.'.$file->extension();
            $storagePath = 'legal_doc/'.$sub_folder;
            
            // Use Laravel's Storage facade for better permission handling
            $path = $file->storeAs($storagePath, $fileName, 'public');
            
            if (!$path) {
                \Log::error('Legal document upload failed: storeAs returned false');
                return null;
            }
    
            return $sub_folder.'/'.$fileName;
        } catch (\Exception $exception) {
            \Log::error('Legal document upload failed: ' . $exception->getMessage());
            return null;
        }
    }
}