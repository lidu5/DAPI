<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\ActivityLogResource;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
{
    $query = ActivityLog::query();

    if ($request->filled('keyword')) {
        $keyword = strtolower($request->input('keyword'));
        $query->whereRaw('LOWER("user") LIKE ?', ["%{$keyword}%"]);
    }

    if ($request->filled('type')) {
        $query->whereRaw('LOWER("type") = ?', [strtolower($request->input('type'))]);
    }

    $limit = $request->input('limit', 15);

    return ActivityLogResource::collection($query->latest()->paginate($limit));
}

    public function show($id)
    {
        return ActivityLog::findOrFail($id);
    }
}
