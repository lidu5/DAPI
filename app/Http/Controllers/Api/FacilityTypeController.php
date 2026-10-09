<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\FacilityType;
use App\Http\Resources\FacilityTypeResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FacilityTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = FacilityType::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $query->orderBy('name', $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $facilityTypes = $query->paginate($limit);

        return FacilityTypeResource::collection($facilityTypes);
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
            $existingFacilityType = FacilityType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
    
            if ($existingFacilityType) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
    
            $facilityType = FacilityType::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('FacilityType %s(%d) was created.', $facilityType->name, $facilityType->id),
                'model' => 'FacilityType',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new FacilityTypeResource($facilityType);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FacilityType $facilityType)
    {
        return new FacilityTypeResource($facilityType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacilityType $facilityType)
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
            $existingFacilityType = FacilityType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $facilityType->id) 
                ->first();
        
            if ($existingFacilityType) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
        
            $facilityType->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('FacilityType %s(%d) was updated.', $facilityType->name, $facilityType->id),
                'model' => 'FacilityType',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        
            return new FacilityTypeResource($facilityType);
        
        } catch (\Illuminate\Database\QueryException $exception) {
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
    public function destroy(FacilityType $facilityType)
    {
        try {
            $facilityType->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('FacilityType %s(%d) was deleted.', $facilityType->name, $facilityType->id),
                'model' => 'FacilityType',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return response()->json(null, 204);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to delete the facility type. Please try again later.'
            ], 500); 
        }
    }
    
}
