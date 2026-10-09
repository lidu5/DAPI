<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\OsSupport;
use App\Http\Resources\OsSupportResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OsSupportController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = OsSupport::query();
    
       
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
    
        $osSupports = $query->paginate($limit);
    
        return OsSupportResource::collection($osSupports);
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

       
        $existingSupport = OsSupport::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingSupport) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409); 
        }

       
        $osSupport = OsSupport::create($validator->validated());
ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('OsSupport %s(%d) was created.', $license ->name, $license ->id),
                'model' => 'OsSupport',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        return new OsSupportResource($osSupport);

    } catch (\Illuminate\Database\QueryException $exception) {
       
        return response()->json([
            'error' => 'An error occurred while creating the OS support record. Please try again later.'
        ], 500); 
    }
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OsSupport  $osSupport
     * @return \Illuminate\Http\Response
     */
    public function show(OsSupport $osSupport)
    {
        return new OsSupportResource($osSupport);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OsSupport  $osSupport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OsSupport $osSupport)
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

        $existingSupport = OsSupport::whereRaw('LOWER(name) = ?', [$normalizedName])
                                    ->where('id', '!=', $osSupport->id)
                                    ->first();

        if ($existingSupport) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        $osSupport->update($validator->validated());

        ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('OsSupport %s(%d) was created.', $license ->name, $license ->id),
                'model' => 'OsSupport',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
          ]);
        return new OsSupportResource($osSupport);

    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while updating the OS support record. Please try again later.'
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OsSupport  $osSupport
     * @return \Illuminate\Http\Response
     */
    public function destroy(OsSupport $osSupport)
    {
        try {
            $osSupport->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('OsSupport %s(%d) was created.', $license ->name, $license ->id),
                'model' => 'OsSupport',
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
