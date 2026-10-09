<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Partner;
use App\Http\Resources\PartnerResource;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Partner::query();
    
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $searchTerm . '%']);
        }
    
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $partners = $query->paginate($limit);
    
        return PartnerResource::collection($partners);
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
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $normalizedName = strtolower($request->input('name'));
    
            $existingPartner = Partner::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingPartner) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409);
            }
    
            $partner = Partner::create($validator->validated());
    
            return new PartnerResource($partner);
    
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An error occurred while creating the partner record. Please try again later.'
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        // Return the partner as a resource
        return new PartnerResource($partner);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
{
    $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $normalizedName = strtolower($request->input('name'));

        $existingPartner = Partner::whereRaw('LOWER(name) = ? AND id != ?', [$normalizedName, $partner->id])->first();

        if ($existingPartner) {
            return response()->json([
                'error' => 'The name you provided already exists. Please choose a different name.'
            ], 409);
        }

        $partner->update($validator->validated());

        return new PartnerResource($partner);

    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json([
            'error' => 'An error occurred while updating the partner record. Please try again later.'
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        try {
            $partner->delete();
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
