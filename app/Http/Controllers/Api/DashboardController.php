<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DigitalHealthProject;
use App\Models\EhaComponent;
use App\Models\Region;
use App\Models\OrganizationUnit;
use App\Models\HealthFocusArea;
use App\Models\HealthSystemChallenge;
use App\Models\DigitalHealthIntervention;


use App\Laravue\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    const TOP_ITEMS = 5;
    //
    public function getTotals(){
        $result = DigitalHealthProject::selectRaw("SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) AS new_projects")
                ->selectRaw("SUM(CASE WHEN status IN ('request registration', 'request cert registration') THEN 1 ELSE 0 END) AS request_reg")                
                ->selectRaw("SUM(CASE WHEN status = 'registration approved' THEN 1 ELSE 0 END) AS reg_apr")
                ->selectRaw("SUM(CASE WHEN is_registered = true THEN 1 ELSE 0 END) AS reg")
                ->selectRaw("SUM(CASE WHEN status = 'request cert competence' THEN 1 ELSE 0 END) AS request_cert_comp")
                ->selectRaw("SUM(CASE WHEN status = 'cert competence' THEN 1 ELSE 0 END) AS cert_comp")
                ->first();
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }

    public function eHAComponentsProjectsCount(){
        $result = EhaComponent::withCount(['projects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])->get();
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }

    public function regionalProjectsCount(){
        $result = Region::withCount(['projects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])
        ->orderBy('projects_count', 'asc')  // or 'asc' for ascending order
        ->get();
        
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }
    

    public function topLeadOrganizations(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
        $result = OrganizationUnit::withCount(['projects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])->orderBy('projects_count', 'desc')->paginate($limit);
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }

    public function topFocusAreas(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
        $result = HealthFocusArea::withCount(['projects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])->orderBy('projects_count', 'desc')->paginate($limit);
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }
    public function topChallenges(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
        $result = HealthSystemChallenge::withCount(['projects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])->orderBy('projects_count', 'desc')->paginate($limit);
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }

    public function projectsByImplementation(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
        $result = DigitalHealthProject::selectRaw("dhs_implemeted, COUNT(*) AS projects_count")
            ->where(function($query) {
                $query->where('is_registered', true);
            })
            ->groupBy('dhs_implemeted')
            ->orderByDesc('projects_count')
            ->paginate($limit);
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }

    public function projectsByStatus(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
    
        $result = DigitalHealthProject::select('current_status', DB::raw('count(*) as projects_count'))
            ->where('is_registered', true) // Add the filter here
            ->groupBy('current_status')
            ->orderByDesc('projects_count')
            ->paginate($limit);
    
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }    

    public function projectsByLicense(Request $request)
    {
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
    
        $result = DigitalHealthProject::select('licenses.name as license_name', DB::raw('count(*) as projects_count'))
            ->join('licenses', 'digital_health_projects.license_id', '=', 'licenses.id')  // Join with the 'licenses' table
            ->where('digital_health_projects.is_registered', true)
            ->groupBy('licenses.name')  // Group by the license name
            ->orderByDesc('projects_count')
            ->paginate($limit);
    
        return response()->json(new JsonResponse($result), Response::HTTP_OK);
    }
    

    public function topPartners(Request $request){
        $limit = $request->get('limit') ?: static::TOP_ITEMS;
        $result = OrganizationUnit::withCount(['digitalHealthProjects' => function (Builder $query) {
            $query->where('is_registered', true);
        }])
        ->orderByDesc('digital_health_projects_count') 
        ->paginate($limit); 
    
        $formattedResult = $result->filter(function($item) {
            return $item->digital_health_projects_count > 0;
        })->map(function($item) {
            return [
                'name' => $item->name,
                'projects_count' => $item->digital_health_projects_count,
            ];
        });
        return response()->json(new JsonResponse($formattedResult), Response::HTTP_OK);
    } 
    
    public function projectsByDhiType(Request $request)
    {
        // Fetch projects with their associated activities and interventions
        $projects = DigitalHealthProject::with(['activities.interventions'])
            ->whereHas('activities.interventions') // Make sure the project has at least one DHI intervention
            ->get();
    
        // Initialize an array to hold the grouped data by DHI type
        $groupedData = [];
    
        // Loop through each project and their activities/interventions
        foreach ($projects as $project) {
            foreach ($project->activities as $activity) {
                foreach ($activity->interventions as $intervention) {
                    // Group interventions by their type
                    $type = $intervention->type; // Assuming 'type' is a field on the DigitalHealthIntervention model
    
                    // If the type isn't already in the groupedData array, initialize it
                    if (!isset($groupedData[$type])) {
                        $groupedData[$type] = [
                            'type' => $type,
                            'projects_count' => 0,
                        ];
                    }
    
                    // Increment the projects count for that DHI type
                    $groupedData[$type]['projects_count']++;
                }
            }
        }
    
        // Convert grouped data to a collection for easier response formatting
        $groupedData = collect($groupedData)->values();
    
        // Return the response as JSON wrapped in JsonResponse
        return response()->json(new JsonResponse($groupedData), Response::HTTP_OK);
    }
    


    
}
