<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\OwnershipType;
use App\Http\Resources\OwnershipTypeResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OwnershipTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = OwnershipType::query();
    
      
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $ownershipTypes = $query->paginate($limit);
    
        return OwnershipTypeResource::collection($ownershipTypes);
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

        $existingSupport = OwnershipType::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingSupport) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        $ownershipType = OwnershipType::create($validator->validated());
ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('OwnershipType %s(%d) was created.', $ownershipType->name, $ownershipType ->id),
                'model' => 'OwnershipType',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        return new OwnershipTypeResource($ownershipType);

    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while creating the ownership type record. Please try again later.'
        ], 500);
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OwnershipType $ownershipType)
    {
        return new OwnershipTypeResource($ownershipType);
    }

   
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OwnershipType $ownershipType)
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
    
            $existingSupport = OwnershipType::whereRaw('LOWER(name) = ?', [$normalizedName])->where('id', '!=', $ownershipType->id)->first();
    
            if ($existingSupport) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            $ownershipType->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('OwnershipType %s(%d) was created.', $ownershipType->name, $ownershipType ->id),
                'model' => 'OwnershipType',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new OwnershipTypeResource($ownershipType);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while updating the ownership type record. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OwnershipType $ownershipType)
    {
        try {
            $ownershipType->delete();
                 ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('OwnershipType %s(%d) was deleted.', $ownershipType->name, $ownershipType ->id),
                'model' => 'OwnershipType',
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
