<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\HealthProfessionalGroup;
use App\Http\Resources\HealthProfessionalGroupResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HealthProfessionalGroupController extends Controller
 {
    const ITEM_PER_PAGE = 15;

    public function index(Request $request)
{
    $query = HealthProfessionalGroup::query();

    if ($request->has('search') && $request->search) {
        $searchTerm = strtolower($request->search);
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
              ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
    }

    $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc';

    if (!in_array($sortDirection, ['asc', 'desc'])) {
        $sortDirection = 'asc';
    }

    $query->orderBy('name', $sortDirection);

    $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;

    $groups = $query->paginate($limit);

    return HealthProfessionalGroupResource::collection($groups);
}

    
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
        $existingGroup = HealthProfessionalGroup::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingGroup) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409); 
        }
        $healthGroup = HealthProfessionalGroup::create($validator->validated());
        ActivityLog::create([
                'type' => 'Create HealthProfessionalGroup',
                'remarks' => sprintf('HealthProfessionalGroup %s(%d) was created.', $healthGroup->name, $healthGroup->id),
                'model' => 'HealthProfessionalGroup',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

        return new HealthProfessionalGroupResource($healthGroup);
    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An unexpected error occurred. Please try again later.'
        ], 500); 
}}


    public function show(HealthProfessionalGroup $healthProfessionalGroup)
    {
        return new HealthProfessionalGroupResource($healthProfessionalGroup);
    }

    public function update(Request $request, HealthProfessionalGroup $healthProfessionalGroup)
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
            $existingGroup = HealthProfessionalGroup::whereRaw('LOWER(name) = ?', [$normalizedName])
                                                    ->where('id', '<>', $healthProfessionalGroup->id)
                                                    ->first();
    
            if ($existingGroup) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
            $healthProfessionalGroup->update($validator->validated());
                ActivityLog::create([
                'type' => 'Update HealthProfessionalGroup',
                'remarks' => sprintf('HealthProfessionalGroup %s(%d) was updated.', $healthGroup->name, $healthGroup->id),
                'model' => 'HealthProfessionalGroup',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

    
            return new HealthProfessionalGroupResource($healthProfessionalGroup);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
    
    public function destroy(HealthProfessionalGroup $healthProfessionalGroup)
    {
        try {
            $healthProfessionalGroup->delete();
                    ActivityLog::create([
                'type' => 'Delete HealthProfessionalGroup',
                'remarks' => sprintf('HealthProfessionalGroup %s(%d) was deleted.', $healthGroup->name, $healthGroup->id),
                'model' => 'HealthProfessionalGroup',
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
