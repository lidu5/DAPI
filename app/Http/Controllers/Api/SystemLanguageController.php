<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\SystemLanguage;
use App\Http\Resources\SystemLanguageResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SystemLanguageController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SystemLanguage::query();

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

        $systemLanguages = $query->paginate($limit);

        return SystemLanguageResource::collection($systemLanguages);
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
            $existing = SystemLanguage::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $systemLanguage = SystemLanguage::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('SystemLanguage %s(%d) was created.', $systemLanguage->name, $systemLanguage->id),
                'model' => 'SystemLanguage',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new SystemLanguageResource($systemLanguage);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'An error occurred while trying to create the system language. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  SystemLanguage $systemLanguage
     * @return \Illuminate\Http\Response
     */
    public function show(SystemLanguage $systemLanguage)
    {
        return new SystemLanguageResource($systemLanguage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SystemLanguage $systemLanguage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemLanguage $systemLanguage)
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
            $existing = SystemLanguage::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
                ->where('id', '!=', $systemLanguage->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'The name already exists. Please choose a different name.'
                ], 409);
            }

            $systemLanguage->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('SystemLanguage %s(%d) was updated.', $systemLanguage->name, $systemLanguage->id),
                'model' => 'SystemLanguage',
                'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
            ]);

            return new SystemLanguageResource($systemLanguage);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SystemLanguage $systemLanguage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemLanguage $systemLanguage)
    {
        try {
            $systemLanguage->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('SystemLanguage %s(%d) was deleted.', $systemLanguage->name, $systemLanguage->id),
                'model' => 'SystemLanguage',
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
