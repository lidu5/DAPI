<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DbmsSupport;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DbmsSupportResource;
use Illuminate\Http\Request;

class DbmsSupportController extends Controller
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
        $query = DbmsSupport::query();

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

        $dbmsSupports = $query->paginate($limit);

        return DbmsSupportResource::collection($dbmsSupports);
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
    
            $existingDbmsSupport = DbmsSupport::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingDbmsSupport) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $dbmsSupport = DbmsSupport::create($validator->validated());
             ActivityLog::create([
    'type' => 'Create',
    'remarks' => sprintf('DbmsSupport %s(%d) was created.', $dbmsSupport->name, $dbmsSupport->id),
    'model' => 'DbmsSupport',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new DbmsSupportResource($dbmsSupport);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DbmsSupport $dbmsSupport
     * @return \Illuminate\Http\Response
     */
    public function show(DbmsSupport $dbmsSupport)
    {
        return new DbmsSupportResource($dbmsSupport);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DbmsSupport $dbmsSupport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DbmsSupport $dbmsSupport)
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
    
            $existingDbmsSupport = DbmsSupport::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $dbmsSupport->id) 
                ->first();
    
            if ($existingDbmsSupport) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $dbmsSupport->update($validator->validated());
             ActivityLog::create([
    'type' => 'Update',
    'remarks' => sprintf('DbmsSupport %s(%d) was updated.', $dbmsSupport->name, $dbmsSupport->id),
    'model' => 'DbmsSupport',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new DbmsSupportResource($dbmsSupport);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DbmsSupport $dbmsSupport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DbmsSupport $dbmsSupport)
    {
        try {
            $dbmsSupport->delete();
             ActivityLog::create([
    'type' => 'Delete',
    'remarks' => sprintf('DbmsSupport %s(%d) was deleted.', $dbmsSupport->name, $dbmsSupport->id),
    'model' => 'DbmsSupport',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return response()->json(null, 204);
        
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred while deleting the record. Please try again later.'
            ], 500); 
        }
    }

}
