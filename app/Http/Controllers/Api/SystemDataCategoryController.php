<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\SystemDataCategory;
use App\Http\Resources\SystemDataCategoryResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SystemDataCategoryController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SystemDataCategory::query();

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

        $systemDataCategories = $query->paginate($limit);

        return SystemDataCategoryResource::collection($systemDataCategories);
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
            $existing = SystemDataCategory::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $systemDataCategory = SystemDataCategory::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('SystemDataCategory %s(%d) was created.', $systemDataCategory->name, $systemDataCategory->id),
                'model' => 'SystemDataCategory',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new SystemDataCategoryResource($systemDataCategory);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the system data category. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  SystemDataCategory $systemDataCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SystemDataCategory $systemDataCategory)
    {
        return new SystemDataCategoryResource($systemDataCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SystemDataCategory $systemDataCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemDataCategory $systemDataCategory)
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
            $existing = SystemDataCategory::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $systemDataCategory->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $systemDataCategory->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('SystemDataCategory %s(%d) was updated.', $systemDataCategory->name, $systemDataCategory->id),
                'model' => 'SystemDataCategory',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new SystemDataCategoryResource($systemDataCategory);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SystemDataCategory $systemDataCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemDataCategory $systemDataCategory)
    {
        try {
            $systemDataCategory->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('SystemDataCategory %s(%d) was deleted.', $systemDataCategory->name, $systemDataCategory->id),
                'model' => 'SystemDataCategory',
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
