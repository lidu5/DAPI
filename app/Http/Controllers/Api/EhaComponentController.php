<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\EhaComponent;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EhaComponentResource;
use Illuminate\Http\Request;

class EhaComponentController extends Controller
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
        $query = EhaComponent::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $query->orderBy('name', 'asc');  

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $ehaComponents = $query->paginate($limit);

        return EhaComponentResource::collection($ehaComponents);
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
            $existingEhaComponent = EhaComponent::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
    
            if ($existingEhaComponent) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $ehaComponent = EhaComponent::create($validator->validated());
             ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('EhaComponent %s(%d) was created.', $ehaComponent->name, $ehaComponent->id),
                'model' => 'EhaComponent',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new EhaComponentResource($ehaComponent);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param \App\Models\EhaComponent $ehaComponent
     * @return \Illuminate\Http\Response
     */
    public function show(EhaComponent $ehaComponent)
    {
        return new EhaComponentResource($ehaComponent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EhaComponent $ehaComponent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EhaComponent $ehaComponent)
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
            $existingEhaComponent = EhaComponent::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
    
            if ($existingEhaComponent && $existingEhaComponent->id !== $ehaComponent->id) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $ehaComponent->update($validator->validated());
    ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('EhaComponent %s(%d) was updated.', $ehaComponent->name, $ehaComponent->id),
                'model' => 'EhaComponent',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new EhaComponentResource($ehaComponent);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\EhaComponent $ehaComponent
     * @return \Illuminate\Http\Response
     */
    public function destroy(EhaComponent $ehaComponent)
    {
        try {
            $ehaComponent->delete();
    ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('EhaComponent %s(%d) was deleted.', $ehaComponent->name, $ehaComponent->id),
                'model' => 'EhaComponent',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return response()->json(null, 204);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    
}
