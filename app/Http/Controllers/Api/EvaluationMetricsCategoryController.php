<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\EvaluationMetricsCategory;
use App\Http\Resources\EvaluationMetricsCategoryResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EvaluationMetricsCategoryController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EvaluationMetricsCategory::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search); 
        
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $sortBy = $request->has('sort_by') && in_array($request->sort_by, ['name', 'weight']) 
                    ? $request->sort_by 
                    : 'name'; 
        
        $query->orderBy($sortBy, $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $evaluationMetricsCategories = $query->paginate($limit);

        return EvaluationMetricsCategoryResource::collection($evaluationMetricsCategories);
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
            'weight' => 'required|numeric',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingCategory = EvaluationMetricsCategory::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingCategory) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }
    
            $evaluationMetricsCategory = EvaluationMetricsCategory::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was created.', $evaluationMetricsCategories->name, $evaluationMetricsCategories->id),
                'model' => 'EvaluationMetricsCategory',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
    
            return new EvaluationMetricsCategoryResource($evaluationMetricsCategory);
    
        } catch (\Exception $exception) {
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
    public function show(EvaluationMetricsCategory $evaluationMetricsCategory)
    {
        return new EvaluationMetricsCategoryResource($evaluationMetricsCategory);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvaluationMetricsCategory $evaluationMetricsCategory)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        try {
            $normalizedName = strtolower($request->input('name'));

            $existingCategory = EvaluationMetricsCategory::whereRaw('LOWER(name) = ?', [$normalizedName])
                ->where('id', '!=', $evaluationMetricsCategory->id)
                ->first();

            if ($existingCategory) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409); 
            }

            $evaluationMetricsCategory->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was updated.', $evaluationMetricsCategories->name, $evaluationMetricsCategories->id),
                'model' => 'EvaluationMetricsCategory',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

            return new EvaluationMetricsCategoryResource($evaluationMetricsCategory);

        } catch (\Exception $exception) {
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
    public function destroy(EvaluationMetricsCategory $evaluationMetricsCategory)
    {
        try {
            $evaluationMetricsCategory->delete();
ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was deleted.', $evaluationMetricsCategories->name, $evaluationMetricsCategories->id),
                'model' => 'EvaluationMetricsCategory',
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
