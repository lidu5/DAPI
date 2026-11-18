<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DataUpdateFrequency;
use App\Http\Resources\DataUpdateFrequencyResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DataUpdateFrequencyController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DataUpdateFrequency::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search);

            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc';

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $query->orderBy('name', $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;

        $dataUpdateFrequencies = $query->paginate($limit);

        return DataUpdateFrequencyResource::collection($dataUpdateFrequencies);
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
            $existing = DataUpdateFrequency::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $dataUpdateFrequency = DataUpdateFrequency::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('DataUpdateFrequency %s(%d) was created.', $dataUpdateFrequency->name, $dataUpdateFrequency->id),
                'model' => 'DataUpdateFrequency',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new DataUpdateFrequencyResource($dataUpdateFrequency);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the data update frequency. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  DataUpdateFrequency $dataUpdateFrequency
     * @return \Illuminate\Http\Response
     */
    public function show(DataUpdateFrequency $dataUpdateFrequency)
    {
        return new DataUpdateFrequencyResource($dataUpdateFrequency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DataUpdateFrequency $dataUpdateFrequency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataUpdateFrequency $dataUpdateFrequency)
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
            $existing = DataUpdateFrequency::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $dataUpdateFrequency->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $dataUpdateFrequency->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('DataUpdateFrequency %s(%d) was updated.', $dataUpdateFrequency->name, $dataUpdateFrequency->id),
                'model' => 'DataUpdateFrequency',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new DataUpdateFrequencyResource($dataUpdateFrequency);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DataUpdateFrequency $dataUpdateFrequency
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataUpdateFrequency $dataUpdateFrequency)
    {
        try {
            $dataUpdateFrequency->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('DataUpdateFrequency %s(%d) was deleted.', $dataUpdateFrequency->name, $dataUpdateFrequency->id),
                'model' => 'DataUpdateFrequency',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
}
