<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthSystemChallenge;
use App\Http\Resources\HealthSystemChallengeResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HealthSystemChallengeController extends Controller
{
    const ITEM_PER_PAGE = 15;

    public function index(Request $request)
    {
        $query = HealthSystemChallenge::query();
    
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(category) LIKE ?', ['%' . $searchTerm . '%']);
        }
    
        $sortDirection = $request->filled('sort_direction') && in_array(strtolower($request->sort_direction), ['asc', 'desc'])
            ? strtolower($request->sort_direction)
            : 'asc';
    
        $query->orderBy('name', $sortDirection);
    
        $limit = $request->has('limit') ? (int) $request->limit : self::ITEM_PER_PAGE;
    
        $challenges = $query->paginate($limit);
    
        return HealthSystemChallengeResource::collection($challenges);
    }
    

    public function create()
    {
        return response()->json([
            'message' => 'Ready to create a new Health System Challenge',
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
           
            $normalizedName = strtolower($request->input('name'));

            $existingChallenge = HealthSystemChallenge::whereRaw('LOWER(name) = ?', [$normalizedName])->first();
    
            if ($existingChallenge) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
            
            $challenge = HealthSystemChallenge::create($validator->validated());
            ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('HealthSystemChallenge %s(%d) was created.', $challenge ->name, $challenge ->id),
                'model' => 'HealthSystemChallenge',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
            return new HealthSystemChallengeResource($challenge);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    
    public function show(HealthSystemChallenge $challenge)
    {
        return new HealthSystemChallengeResource($challenge);
    }

    public function edit(HealthSystemChallenge $challenge)
    {
        return response()->json([
            'message' => 'Ready to edit',
            'data' => new HealthSystemChallengeResource($challenge),
        ]);
    }

    public function update(Request $request, HealthSystemChallenge $challenge)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            
            $normalizedName = strtolower($request->input('name'));
    
            
            $existingChallenge = HealthSystemChallenge::whereRaw('LOWER(name) = ?', [$normalizedName])
                                                       ->where('id', '<>', $challenge->id)
                                                       ->first();
    
            if ($existingChallenge) {
                return response()->json([
                    'error' => 'The name you provided already exists. Please choose a different name.'
                ], 409); 
            }
    
        
            $challenge->update($validator->validated());
            ActivityLog::create([
                'type' => 'Update',
                'remarks' => sprintf('HealthSystemChallenge %s(%d) was updated.', $challenge ->name, $challenge ->id),
                'model' => 'HealthSystemChallenge',
               'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
    
    
            return new HealthSystemChallengeResource($challenge);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500); 
        }
    }
    

    public function destroy(HealthSystemChallenge $challenge)
    {
        try {
            $challenge->delete();
            ActivityLog::create([
                'type' => 'Delete',
                'remarks' => sprintf('HealthSystemChallenge %s(%d) was deleted.', $challenge ->name, $challenge ->id),
                'model' => 'HealthSystemChallenge',
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
