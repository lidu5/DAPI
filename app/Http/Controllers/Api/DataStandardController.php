<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DataStandard;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DataStandardResource;
use Illuminate\Http\Request;

class DataStandardController extends Controller
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
        $query = DataStandard::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $sortBy = $request->has('sort_by') ? $request->sort_by : 'name'; 
        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc';

        if (!in_array($sortBy, ['name', 'category'])) {
            $sortBy = 'name'; 
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $query->orderBy($sortBy, $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $dataStandards = $query->paginate($limit);

        return DataStandardResource::collection($dataStandards);
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
            'category' => 'required|string|max:255', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        try {
            $normalizedName = strtolower($request->input('name'));

            $existingDataStandard = DataStandard::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

            if ($existingDataStandard) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }

            $dataStandard = DataStandard::create($validator->validated());
            ActivityLog::create([
    'type' => 'Create',
    'remarks' => sprintf('DataStandard %s(%d) was created.', $dataStandard->name, $dataStandard->id),
    'model' => 'DataStandard',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

            return new DataStandardResource($dataStandard);

        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataStandard $dataStandard
     * @return \Illuminate\Http\Response
     */
    public function show(DataStandard $dataStandard)
    {
        return new DataStandardResource($dataStandard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DataStandard $dataStandard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataStandard $dataStandard)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255', 
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        try {
            $normalizedName = strtolower($request->input('name'));

            $existingDataStandard = DataStandard::whereRaw('LOWER(name) = ? AND id != ?', [$normalizedName, $dataStandard->id])->first();

            if ($existingDataStandard) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409);
            }

            $dataStandard->update($validator->validated());
             ActivityLog::create([
    'type' => 'Update',
    'remarks' => sprintf('DataStandard %s(%d) was updated.', $dataStandard->name, $dataStandard->id),
    'model' => 'DataStandard',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

            return new DataStandardResource($dataStandard);

        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DataStandard $dataStandard
     * @return \Illuminate\Http\Response
     */
   public function destroy(DataStandard $dataStandard)
    {
        try {
            $dataStandard->delete();
         ActivityLog::create([
    'type' => 'Delete',
    'remarks' => sprintf('DataStandard %s(%d) was deleted.', $dataStandard->name, $dataStandard->id),
    'model' => 'DataStandard',
    'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
            return response()->json(null, 204);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while deleting the data standard. Please try again later.'
            ], 500);
        }
    }
}
