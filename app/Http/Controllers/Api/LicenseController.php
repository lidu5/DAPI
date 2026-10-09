<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\License; 
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LicenseResource;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = License::query();
    
        // Case-insensitive search
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
    
        // Validate and set sorting direction
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
        // Dynamic pagination
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $licenses = $query->paginate($limit);
    
        return LicenseResource::collection($licenses);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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

        
        $existingLicense = License::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingLicense) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        $license = License::create($validator->validated());
        ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('License %s(%d) was created.', $license ->name, $license ->id),
                'model' => 'License',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
        return new LicenseResource($license);
    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An unexpected error occurred. Please try again later.'
        ], 500); // 500 Internal Server Error status
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(License $license)
    {
        return new LicenseResource($license);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, License $license)
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
    
            $existingLicense = License::whereRaw('LOWER(name) = ?', [$normalizedName])
                                       ->where('id', '<>', $license->id)
                                       ->first();
    
            if ($existingLicense) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            $license->update($validator->validated());
    ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('License %s(%d) was updated.', $license ->name, $license ->id),
                'model' => 'License',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new LicenseResource($license);
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
    public function destroy(License $license)
    {
        try {
            $license->delete();
             ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('License %s(%d) was deleted.', $license ->name, $license ->id),
                'model' => 'License',
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
