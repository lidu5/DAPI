<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ProgrammingLanguage;
use App\Http\Resources\ProgrammingLanguageResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProgrammingLanguageController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ProgrammingLanguage::query();
    
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(type) LIKE ?', ['%' . $searchTerm . '%']);
        }
    
       
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
  
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $programmingLanguages = $query->paginate($limit);
    
        return ProgrammingLanguageResource::collection($programmingLanguages);
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
            'type' => 'nullable|string',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingLanguage = ProgrammingLanguage::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingLanguage) {
                return response()->json([
                    'error' => 'The programming language name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            $programmingLanguage = ProgrammingLanguage::create($validator->validated());
     ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('ProgrammingLanguage %s(%d) was created.', $programmingLanguage->name, $programmingLanguage ->id),
                'model' => 'ProgrammingLanguage',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new ProgrammingLanguageResource($programmingLanguage);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while creating the programming language record. Please try again later.'
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function show(ProgrammingLanguage $programmingLanguage)
    {
        return new ProgrammingLanguageResource($programmingLanguage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgrammingLanguage $programmingLanguage)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingLanguage = ProgrammingLanguage::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $programmingLanguage->id) // Ensure we do not check the current record
                ->first();
    
            if ($existingLanguage) {
                return response()->json([
                    'error' => 'The programming language name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            $programmingLanguage->update($validator->validated());
     ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('ProgrammingLanguage %s(%d) was updated.', $programmingLanguage->name, $programmingLanguage ->id),
                'model' => 'ProgrammingLanguage',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return new ProgrammingLanguageResource($programmingLanguage);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while updating the programming language record. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgrammingLanguage  $programmingLanguage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgrammingLanguage $programmingLanguage)
    {
        try {
            $programmingLanguage->delete();
             ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('ProgrammingLanguage %s(%d) was deleted.', $programmingLanguage->name, $programmingLanguage ->id),
                'model' => 'ProgrammingLanguage',
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
