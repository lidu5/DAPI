<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\DataExchangeType;
use App\Http\Resources\DataExchangeTypeResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DataExchangeTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DataExchangeType::query();

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

        $dataExchangeTypes = $query->paginate($limit);

        return DataExchangeTypeResource::collection($dataExchangeTypes);
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
            $existing = DataExchangeType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $dataExchangeType = DataExchangeType::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('DataExchangeType %s(%d) was created.', $dataExchangeType->name, $dataExchangeType->id),
                'model' => 'DataExchangeType',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new DataExchangeTypeResource($dataExchangeType);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the data exchange type. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  DataExchangeType $dataExchangeType
     * @return \Illuminate\Http\Response
     */
    public function show(DataExchangeType $dataExchangeType)
    {
        return new DataExchangeTypeResource($dataExchangeType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DataExchangeType $dataExchangeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataExchangeType $dataExchangeType)
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
            $existing = DataExchangeType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $dataExchangeType->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $dataExchangeType->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('DataExchangeType %s(%d) was updated.', $dataExchangeType->name, $dataExchangeType->id),
                'model' => 'DataExchangeType',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new DataExchangeTypeResource($dataExchangeType);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DataExchangeType $dataExchangeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataExchangeType $dataExchangeType)
    {
        try {
            $dataExchangeType->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('DataExchangeType %s(%d) was deleted.', $dataExchangeType->name, $dataExchangeType->id),
                'model' => 'DataExchangeType',
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
