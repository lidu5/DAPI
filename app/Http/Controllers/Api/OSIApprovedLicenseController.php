<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\OSIApprovedLicense;
use App\Http\Resources\OSIApprovedLicenseResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OSIApprovedLicenseController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = OSIApprovedLicense::query();

  
    if ($request->filled('search')) {
        $searchTerm = strtolower($request->search);
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
    }

    
    $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
        ? strtolower($request->sort_direction)
        : 'asc';

    $query->orderBy('name', $sortDirection);

  
    $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;

    $licenses = $query->paginate($limit);

    return OSIApprovedLicenseResource::collection($licenses);
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

      
        $existingLicense = OSIApprovedLicense::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingLicense) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409); 
        }

        
        $license = OSIApprovedLicense::create($validator->validated());
        ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('OSIApprovedLicense %s(%d) was created.', $license ->name, $license ->id),
                'model' => 'OSIApprovedLicense',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

        return new OSIApprovedLicenseResource($license);

    } catch (\Illuminate\Database\QueryException $exception) {
       
        return response()->json([
            'error' => 'An error occurred while creating the OSI approved license. Please try again later.'
        ], 500); 
    }
}


    /**
     * Display the specified resource.
     *
     * @param  OSIApprovedLicense  $license
     * @return \Illuminate\Http\Response
     */
    public function show(OSIApprovedLicense $osiApprovedLicense)
{
    return new OSIApprovedLicenseResource($osiApprovedLicense);
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
     * @param  OSIApprovedLicense  $license
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OSIApprovedLicense $osiApprovedLicense)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); 
        }
    
        try {
           
            $normalizedName = strtolower($request->input('name'));
    
           
            $existingLicense = OSIApprovedLicense::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $osiApprovedLicense->id) 
                ->first();
    
            if ($existingLicense) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            
            $osiApprovedLicense->update($validator->validated());
    ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('OSIApprovedLicense %s(%d) was updated.', $license ->name, $license ->id),
                'model' => 'OSIApprovedLicense',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new OSIApprovedLicenseResource($osiApprovedLicense);
    
        } catch (\Illuminate\Database\QueryException $exception) {
           
            return response()->json([
                'error' => 'An error occurred while updating the OSI approved license. Please try again later.'
            ], 500); 
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  OSIApprovedLicense  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy(OSIApprovedLicense $osiApprovedLicense)
{
    try {
        $osiApprovedLicense->delete();
        ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('OSIApprovedLicense %s(%d) was deleted.', $license ->name, $license ->id),
                'model' => 'OSIApprovedLicense',
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
