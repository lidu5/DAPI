<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Http\Resources\ExternalResource;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ResourceController extends Controller
{
    const ITEM_PER_PAGE = 15;

    public function index(Request $request)
    {
        $searchParams = $request->all();
        $typeQuery = Resource::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $typeQuery->where('name', 'ilike', '%' . $keyword . '%');
        }

        return ExternalResource::collection($typeQuery->paginate($limit));
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:resources,name',
            'description' => 'required|string',
            'file' => 'required|file|max:2048',
        ], [
            'name.required' => 'Please enter a resource name.',
            'name.unique' => 'A resource with this name already exists.',
            'description.required' => 'Please provide a description.',
            'file.required' => 'Please upload a file.',
            'file.max' => 'The file size must be less than 2MB.',
        ]);

        $file = $request->file('file');
        $sub_folder = date("F") . date("Y");
        $location = 'storage/external_resource/' . $sub_folder;

        if (!file_exists(public_path($location))) {
            mkdir(public_path($location), 0755, true);
        }

        $fileName = time() . '.' . $file->extension();
        $file->move(public_path($location), $fileName);

        $resource = Resource::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'file' => $sub_folder . '/' . $fileName,
        ]);
             ActivityLog::create([
                'type' => 'Create',
                'remarks' => sprintf('Resource %s(%d) was created.', $resource->name, $resource ->id),
                'model' => 'Resource',
                 'user' => sprintf('%s(%d)', auth()->user()->name, auth()->id())
         ]);
        return new ExternalResource($resource);

    } catch (\Illuminate\Validation\ValidationException $e) {
        $firstError = collect($e->errors())->flatten()->first();

        return response()->json([
            'message' => $firstError
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
