<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\EvaluationMetrics;
use App\Http\Resources\EvaluationMetricsResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EvaluationMetricsController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = EvaluationMetrics::query();

        $query->with('category');

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search);
    
            $query->whereRaw('LOWER(elements) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                      $categoryQuery->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                  });
        }
    

        if ($request->has('evaluation_metrics_category_id') && $request->evaluation_metrics_category_id) {
            $query->where('evaluation_metrics_category_id', $request->evaluation_metrics_category_id);
        }

        $sortDirection = $request->has('sort_direction') ? strtolower($request->sort_direction) : 'asc'; 
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; 
        }

        $sortBy = $request->has('sort_by') && in_array($request->sort_by, ['elements', 'weight']) 
                    ? $request->sort_by 
                    : 'elements'; 
        
        $query->orderBy($sortBy, $sortDirection);

        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
        $evaluationMetrics = $query->paginate($limit);

        return EvaluationMetricsResource::collection($evaluationMetrics);
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
            'elements' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'evaluation_metrics_category_id' => 'required|exists:evaluation_metrics_categories,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
    
        try {
            $existingEvaluationMetrics = EvaluationMetrics::whereRaw('LOWER(elements) = ?', [strtolower($request->input('elements'))])->first();
    
            if ($existingEvaluationMetrics) {
                return response()->json([
                    'error' => 'The elements already exist. Please choose a different name.'
                ], 409); 
            }
    
            $evaluationMetrics = EvaluationMetrics::create($validator->validated());
    
            $evaluationMetrics->load('category');
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was created.', $evaluationMetrics->name, $evaluationMetrics->id),
                'model' => 'EvaluationMetrics',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new EvaluationMetricsResource($evaluationMetrics);
    
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
    public function show(EvaluationMetrics $evaluationMetric)
    {
        $evaluationMetric->load('category');

        return new EvaluationMetricsResource($evaluationMetric);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvaluationMetrics $evaluationMetric)
    {
        $rules = [
            'elements' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'evaluation_metrics_category_id' => 'required|exists:evaluation_metrics_categories,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        try {
            $existingEvaluationMetrics = EvaluationMetrics::whereRaw('LOWER(elements) = ?', [strtolower($request->input('elements'))])
                ->where('id', '!=', $evaluationMetric->id)
                ->first();

            if ($existingEvaluationMetrics) {
                return response()->json([
                    'error' => 'The elements already exist. Please choose a different name.'
                ], 409); 
            }

            $evaluationMetric->update($validator->validated());

            $evaluationMetric->load('category');
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was updated.', $evaluationMetrics->name, $evaluationMetrics->id),
                'model' => 'EvaluationMetrics',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

            return new EvaluationMetricsResource($evaluationMetric);

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
    public function destroy(EvaluationMetrics $evaluationMetric)
    {
        try {
            $evaluationMetric->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('EvaluationMetricsCategory %s(%d) was deleted.', $evaluationMetrics->name, $evaluationMetrics->id),
                'model' => 'EvaluationMetrics',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

            return response()->json(null, 204);

        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }

}
