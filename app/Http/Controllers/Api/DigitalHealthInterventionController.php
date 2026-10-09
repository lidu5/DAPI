<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DigitalHealthIntervention;
use App\Http\Resources\DigitalHealthInterventionResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DigitalHealthInterventionController extends Controller
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
        $query = DigitalHealthIntervention::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(category) LIKE ?', ['%' . $searchTerm . '%']);
        }

        if ($request->has('type') && in_array($request->type, [
            DigitalHealthIntervention::TYPE_PERSON,
            DigitalHealthIntervention::TYPE_HEALTHCARE_PROVIDERS,
            DigitalHealthIntervention::TYPE_HEALTH_MANAGEMENT_AND_SUPPORT_PERSONNEL,
            DigitalHealthIntervention::TYPE_DATA_SERVICES,
        ])) {
            $query->where('type', $request->type);
        }

        $sortBy = $request->has('sort_by') ? $request->sort_by : 'name'; 
        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        if (!in_array($sortBy, ['name', 'category'])) {
            $sortBy = 'name'; 
        }

        $query->orderBy($sortBy, $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $digitalHealthInterventions = $query->paginate($limit);

        return DigitalHealthInterventionResource::collection($digitalHealthInterventions);
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
            'category' => 'required|string|max:255',
            'type' => 'required|string|in:' . DigitalHealthIntervention::TYPE_PERSON . ',' . DigitalHealthIntervention::TYPE_HEALTHCARE_PROVIDERS . ',' . DigitalHealthIntervention::TYPE_HEALTH_MANAGEMENT_AND_SUPPORT_PERSONNEL . ',' . DigitalHealthIntervention::TYPE_DATA_SERVICES,
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $existingIntervention = DigitalHealthIntervention::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
    
            if ($existingIntervention) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $digitalHealthIntervention = DigitalHealthIntervention::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('DigitalHealthIntervention %s(%d) was created.', $digitalHealthIntervention->name, $digitalHealthIntervention->id),
                'model' => 'DigitalHealthIntervention',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new DigitalHealthInterventionResource($digitalHealthIntervention);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DigitalHealthIntervention $digitalHealthIntervention
     * @return \Illuminate\Http\Response
     */

    public function show(DigitalHealthIntervention $digitalHealthIntervention)
    {
        return new DigitalHealthInterventionResource($digitalHealthIntervention);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DigitalHealthIntervention $digitalHealthIntervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DigitalHealthIntervention $digitalHealthIntervention)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|string|in:' . DigitalHealthIntervention::TYPE_PERSON . ',' . DigitalHealthIntervention::TYPE_HEALTHCARE_PROVIDERS . ',' . DigitalHealthIntervention::TYPE_HEALTH_MANAGEMENT_AND_SUPPORT_PERSONNEL . ',' . DigitalHealthIntervention::TYPE_DATA_SERVICES,
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $existingIntervention = DigitalHealthIntervention::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->where('id', '!=', $digitalHealthIntervention->id)->first();
    
            if ($existingIntervention) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }
    
            $digitalHealthIntervention->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('DigitalHealthIntervention %s(%d) was updated.', $digitalHealthIntervention->name, $digitalHealthIntervention->id),
                'model' => 'DigitalHealthIntervention',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new DigitalHealthInterventionResource($digitalHealthIntervention);
    
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DigitalHealthIntervention $digitalHealthIntervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(DigitalHealthIntervention $digitalHealthIntervention)
    {
        try {
            $digitalHealthIntervention->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('DigitalHealthIntervention %s(%d) was deleted.', $digitalHealthIntervention->name, $digitalHealthIntervention->id),
                'model' => 'DigitalHealthIntervention',
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
