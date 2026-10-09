<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\OrganizationUnit;
use App\Http\Resources\OrganizationUnitResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganizationUnitController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = OrganizationUnit::query();

    // Case-insensitive search for name and description
    if ($request->filled('search')) {
        $searchTerm = strtolower($request->search);
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
              ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
    }

    // Validate and set sorting direction
    $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
        ? strtolower($request->sort_direction)
        : 'asc';

    $query->orderBy('name', $sortDirection);

    // Dynamic pagination with fallback to default
    $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;

    $organizationUnits = $query->paginate($limit);

    return OrganizationUnitResource::collection($organizationUnits);
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
        'description' => 'nullable|string',
        'type' => 'required|string|max:255', // Removed strict validation
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $normalizedName = strtolower($request->input('name'));
        $existingOrganizationUnit = OrganizationUnit::whereRaw('LOWER(name) = ?', [$normalizedName])->first();

        if ($existingOrganizationUnit) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        // Assign default type if not provided
        $validatedData = $validator->validated();
        if (!isset($validatedData['type'])) {
            $validatedData['type'] = 'IMPLEMENTING PARTNER';
        }

        $organizationUnit = OrganizationUnit::create($validatedData);
          ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('OrganizationUnit %s(%d) was created.', $organizationUnit ->name, $organizationUnit ->id),
                'model' => 'OrganizationUnit',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

        return new OrganizationUnitResource($organizationUnit);

    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while creating the organization unit. Please try again later.'
        ], 500);
    }
}

    
    /**
     * Display the specified resource.
     *
     * @param  OrganizationUnit  $organizationUnit
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationUnit $organizationUnit)
    {
        return new OrganizationUnitResource($organizationUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  OrganizationUnit  $organizationUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationUnit $organizationUnit)
{
    $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|string|max:255', // Removed strict validation
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $normalizedName = strtolower($request->input('name'));
        $existingOrganizationUnit = OrganizationUnit::whereRaw('LOWER(name) = ?', [$normalizedName])
            ->where('id', '!=', $organizationUnit->id)
            ->first();

        if ($existingOrganizationUnit) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        $organizationUnit->update($validator->validated());
        ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('OrganizationUnit %s(%d) was updated.', $organizationUnit ->name, $organizationUnit ->id),
                'model' => 'OrganizationUnit',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);

        return new OrganizationUnitResource($organizationUnit);

    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while updating the organization unit. Please try again later.'
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  OrganizationUnit  $organizationUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationUnit $organizationUnit)
    {
        try {
            $organizationUnit->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('OrganizationUnit %s(%d) was deleted.', $organizationUnit ->name, $organizationUnit ->id),
                'model' => 'OrganizationUnit',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        return response()->json(null, 204);
    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while trying to delete this record. It might be referenced elsewhere.'
        ], 400); 
    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'An unexpected error occurred. Please try again later.'
        ], 500); 
    }
    }
}
