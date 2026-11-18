<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\IdentifierType;
use App\Http\Resources\IdentifierTypeResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class IdentifierTypeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = IdentifierType::query();

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

        $identifierTypes = $query->paginate($limit);

        return IdentifierTypeResource::collection($identifierTypes);
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
            $existing = IdentifierType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $identifierType = IdentifierType::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('IdentifierType %s(%d) was created.', $identifierType->name, $identifierType->id),
                'model' => 'IdentifierType',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new IdentifierTypeResource($identifierType);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the identifier type. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  IdentifierType $identifierType
     * @return \Illuminate\Http\Response
     */
    public function show(IdentifierType $identifierType)
    {
        return new IdentifierTypeResource($identifierType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  IdentifierType $identifierType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdentifierType $identifierType)
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
            $existing = IdentifierType::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $identifierType->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $identifierType->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('IdentifierType %s(%d) was updated.', $identifierType->name, $identifierType->id),
                'model' => 'IdentifierType',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new IdentifierTypeResource($identifierType);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IdentifierType $identifierType
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdentifierType $identifierType)
    {
        try {
            $identifierType->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('IdentifierType %s(%d) was deleted.', $identifierType->name, $identifierType->id),
                'model' => 'IdentifierType',
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
