<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ApplicationPlatform;
use App\Http\Resources\ApplicationPlatformResource;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;



class ApplicationPlatformController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ApplicationPlatform::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE; 

        $query->orderBy('name', $sortDirection);

        $applicationPlatforms = $query->paginate($limit); 

        return ApplicationPlatformResource::collection($applicationPlatforms);
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
    
        $messages = [
            'name.unique' => 'The name must be unique. Please choose a different name.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
        
            $existingPlatform = ApplicationPlatform::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
        
            if ($existingPlatform) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
        
            $applicationPlatform = ApplicationPlatform::create($validator->validated());
            ActivityLog::create([
    'type' => 'Create',
    'remarks' => sprintf('Application Platform %s(%d) was created.', $applicationPlatform->name, $applicationPlatform->id),
    'model' => 'ApplicationPlatform',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

        
            return new ApplicationPlatformResource($applicationPlatform);
        
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
    public function show(ApplicationPlatform $applicationPlatform)
    {
        // Return the application platform as a resource
        return new ApplicationPlatformResource($applicationPlatform);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationPlatform $applicationPlatform)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    
        $messages = [
            'name.unique' => 'The name must be unique. Please choose a different name.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => collect($validator->errors()->toArray())->mapWithKeys(function ($messages, $field) {
                    return [$field => implode(' ', $messages)];
                }),
            ], 422); 
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingPlatform = ApplicationPlatform::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $applicationPlatform->id)
                ->first();
    
            if ($existingPlatform) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            $applicationPlatform->update($validator->validated());
                 ActivityLog::create([
    'type' => 'Update',
    'remarks' => sprintf('Application Platform %s(%d) was updated.', $applicationPlatform->name, $applicationPlatform->id),
    'model' => 'ApplicationPlatform',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
]);

            return new ApplicationPlatformResource($applicationPlatform);
    
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
    public function destroy(ApplicationPlatform $applicationPlatform)
    {
        try {
            $applicationPlatform->delete();
ActivityLog::create([
            'type' => 'Delete',
            'remarks' => sprintf('Application Platform %s(%d) was deleted.', $applicationPlatform->name, $applicationPlatform->id),
            'model' => 'ApplicationPlatform',
            'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
        ]);
    
            return response()->json(null, 204);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while deleting the application platform. Please try again later.'
            ], 500);
        }
    }
}
