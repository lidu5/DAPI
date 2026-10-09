<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\HealthFocusArea;
use App\Http\Resources\HealthFocusAreaResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HealthFocusAreaController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = HealthFocusArea::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $query->orderBy('name', $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE; 

        $healthFocusAreas = $query->paginate($limit);

        return HealthFocusAreaResource::collection($healthFocusAreas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $existingHealthFocusArea = HealthFocusArea::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
    
            if ($existingHealthFocusArea) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $healthFocusArea = HealthFocusArea::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('HealthFocusArea %s(%d) was created.', $healthFocusArea->name, $healthFocusArea->id),
                'model' => 'HealthFocusArea',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new HealthFocusAreaResource($healthFocusArea);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the health focus area. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HealthFocusArea $healthFocusArea)
    {
        return new HealthFocusAreaResource($healthFocusArea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthFocusArea $healthFocusArea)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $existingHealthFocusArea = HealthFocusArea::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $healthFocusArea->id)
                ->first();
    
            if ($existingHealthFocusArea) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
    
            $healthFocusArea->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('HealthFocusArea %s(%d) was updated.', $healthFocusArea->name, $healthFocusArea->id),
                'model' => 'HealthFocusArea',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
    
            return new HealthFocusAreaResource($healthFocusArea);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthFocusArea $healthFocusArea)
    {
        try {
            $healthFocusArea->delete();
    ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('HealthFocusArea %s(%d) was deleted.', $healthFocusArea->name, $healthFocusArea->id),
                'model' => 'HealthFocusArea',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    
}
