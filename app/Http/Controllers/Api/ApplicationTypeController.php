<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicationType;
use App\Http\Resources\ApplicationTypeResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    public function index(Request $request)
    {
        $query = ApplicationType::query();
    
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
    
        if ($request->filled('eha_component_id')) {
            $query->where('eha_component_id', $request->eha_component_id);
        }
    
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $applicationTypes = $query->paginate($limit);
    
        return ApplicationTypeResource::collection($applicationTypes);
    }
    
    public function create()
    {
        return response()->json([
            'message' => 'Ready to create a new Application Type',
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'eha_component_id' => 'required|exists:eha_components,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
            $existingType = ApplicationType::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingType) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            $applicationType = ApplicationType::create($validator->validated());
     ActivityLog::create([
    'type' => 'Create',
    'remarks' => sprintf('ApplicationType %s(%d) was created.', $applicationType->name, $applicationType->id),
    'model' => 'ApplicationType',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new ApplicationTypeResource($applicationType);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
    public function show(ApplicationType $applicationType)
    {
        return new ApplicationTypeResource($applicationType);
    }

    public function edit(ApplicationType $applicationType)
    {
        return response()->json([
            'message' => 'Ready to edit',
            'data' => new ApplicationTypeResource($applicationType),
        ]);
    }

    public function update(Request $request, ApplicationType $applicationType)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'eha_component_id' => 'required|exists:eha_components,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
            $existingType = ApplicationType::whereRaw('LOWER(name) = ?', [$normalizedName])
                                           ->where('id', '<>', $applicationType->id)
                                           ->first();
    
            if ($existingType) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            $applicationType->update($validator->validated());
             ActivityLog::create([
    'type' => 'Update',
    'remarks' => sprintf('ApplicationType %s(%d) was updated.', $applicationType->name, $applicationType->id),
    'model' => 'ApplicationType',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new ApplicationTypeResource($applicationType);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
    public function destroy(ApplicationType $applicationType)
    {
        try {
            $applicationType->delete();
             ActivityLog::create([
    'type' => 'Delete',
    'remarks' => sprintf('ApplicationType %s(%d) was deleted.', $applicationType->name, $applicationType->id),
    'model' => 'ApplicationType',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return response()->json(null, 204);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to delete this record. It might be referenced elsewhere.'
            ], 400); 
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
}
