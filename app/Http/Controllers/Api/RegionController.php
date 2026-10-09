<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Region;
use App\Http\Resources\RegionResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Region::query();

  
    if ($request->filled('search')) {
        $searchTerm = strtolower($request->search);
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
    }

   
    $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
        ? strtolower($request->sort_direction)
        : 'asc';

    $query->orderBy('name', $sortDirection);

    $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;

    $regions = $query->paginate($limit);

    return RegionResource::collection($regions);
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
            $normalizedName = strtolower($request->input('name'));
    
            $existingRegion = Region::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingRegion) {
                return response()->json([
                    'error' => 'The region name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            $region = Region::create($validator->validated());
             ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('Region %s(%d) was created.', $region->name, $region ->id),
                'model' => 'Region',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new RegionResource($region);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while creating the region. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        return new RegionResource($region);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
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
            $normalizedName = strtolower($request->input('name'));
    
            $existingRegion = Region::whereRaw('LOWER(name) = ?', [$normalizedName])->where('id', '!=', $region->id)->first();
    
            if ($existingRegion) {
                return response()->json([
                    'error' => 'The region name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            $region->update($validator->validated());
                 ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('Region %s(%d) was updated.', $region->name, $region ->id),
                'model' => 'Region',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new RegionResource($region);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while updating the region. Please try again later.'
            ], 500); 
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        try {
            $region->delete();
                ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('Region %s(%d) was deleted.', $region->name, $region ->id),
                'model' => 'Region',
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
