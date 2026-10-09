<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DeploymentLocation;
use App\Http\Resources\DeploymentLocationResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeploymentLocationController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DeploymentLocation::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; // Default sorting direction
        }

        $query->orderBy('name', $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $deploymentLocations = $query->paginate($limit);

        return DeploymentLocationResource::collection($deploymentLocations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
        
            $existingDeploymentLocation = DeploymentLocation::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
        
            if ($existingDeploymentLocation) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
        
            $deploymentLocation = DeploymentLocation::create($validator->validated());
             ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('DeploymentLocation %s(%d) was created.', $deploymentLocation->name, $deploymentLocation->id),
                'model' => 'DeploymentLocation',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        
            return new DeploymentLocationResource($deploymentLocation);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param \App\Models\DeploymentLocation $deploymentLocation
     * @return \Illuminate\Http\Response
     */

    public function show(DeploymentLocation $deploymentLocation)
    {
        return new DeploymentLocationResource($deploymentLocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeploymentLocation $deploymentLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeploymentLocation $deploymentLocation)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingDeploymentLocation = DeploymentLocation::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $deploymentLocation->id) 
                ->first();
    
            if ($existingDeploymentLocation) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
    
            $deploymentLocation->update($validator->validated());
       ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('DeploymentLocation %s(%d) was updated.', $deploymentLocation->name, $deploymentLocation->id),
                'model' => 'DeploymentLocation',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new DeploymentLocationResource($deploymentLocation);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DeploymentLocation $deploymentLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeploymentLocation $deploymentLocation)
    {
        try {
            $deploymentLocation->delete();
    ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('DeploymentLocation %s(%d) was deleted.', $deploymentLocation->name, $deploymentLocation->id),
                'model' => 'DeploymentLocation',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return response()->json(null, 204);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
}
