<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Laravue\Models\Permission;
use App\Laravue\Models\Role;
use App\Laravue\Models\User;
use App\Laravue\Acl;
use App\Laravue\JsonResponse;

use App\Http\Resources\UserResource;
use App\Http\Resources\PermissionResource;

use App\Models\ActivityLog;

use Validator;

class UserController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the user resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|ResourceCollection
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $userQuery = User::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $role = Arr::get($searchParams, 'role', '');
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($role)) {
            $userQuery->whereHas('roles', function($q) use ($role) { $q->where('name', $role); });
        }

        if (!empty($keyword)) {
            $userQuery->where('name', 'ilike', '%' . $keyword . '%');
            $userQuery->where('email', 'ilike', '%' . $keyword . '%');
        }

        return UserResource::collection($userQuery->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $this->getValidationRules(),
                [
                    'password' => ['required', 'min:6'],
                    'confirmPassword' => 'same:password',
                ]
            )
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $user = User::create([
                'name' => $params['name'],
                'email' => $params['email'],
                'phone_number' => $params['phone_number'],
                'password' => Hash::make($params['password']),
            ]);
            $role = Role::findByName($params['role']);
            $user->syncRoles($role);

            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User    $user
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if ($user === null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $currentUser = Auth::user();

        if (!$currentUser->isAdmin() && $user->isAdmin()) {
            return response()->json(['error' => 'Admin can not be modified'], 403);
        }

        if (!$currentUser->isAdmin()
            && $currentUser->id !== $user->id
            && !$currentUser->hasPermission(\App\Laravue\Acl::PERMISSION_USER_MANAGE)
        ) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $validator = Validator::make($request->all(), $this->getValidationRules(false));
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $email = $request->get('email');
            $found = User::where('email', $email)->first();
            if ($found && $found->id !== $user->id) {
                return response()->json(['error' => 'Email has been taken'], 403);
            }

            $user->name = $request->get('name');
            $user->email = $email;
            $user->phone_number = $request->get('phone_number');
            $user->save();

            if($request->get('role') != null){
                $role = Role::findByName($request->get('role'));
                $user->syncRoles($role);
            }

            ActivityLog::create([
                'type' => 'Profile Update',
                'remarks' => sprintf('%s(%d) updated',$user->name, $user->id),
                'model' => 'User',
                'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
            ]);

            return new UserResource($user);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User    $user
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function updatePermissions(Request $request, User $user)
    {
        if ($user === null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->isAdmin()) {
            return response()->json(['error' => 'Admin can not be modified'], 403);
        }

        $permissionIds = $request->get('permissions', []);
        $rolePermissionIds = array_map(
            function($permission) {
                return $permission['id'];
            },

            $user->getPermissionsViaRoles()->toArray()
        );

        $newPermissionIds = array_diff($permissionIds, $rolePermissionIds);
        $permissions = Permission::allowed()->whereIn('id', $newPermissionIds)->get();
        $user->syncPermissions($permissions);
        return new UserResource($user);
    }

    public function changePassword(Request $request, User $user){
        if ($user === null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $isAdmin = false;
        if (Auth::user()->isAdmin())
            $isAdmin = true;

        $validator = Validator::make($request->all(), $this->getAccountValidationRules($isAdmin));

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            if(!$isAdmin){

                if(!Hash::check($request->get('password'), $user->password))
                return response()->json(['errors' => 
                    'Your current password does not match with the password you provided. Please try again.'], 403);
                if(strcmp($request->get('password'), $request->get('newPassword')) == 0)
                return response()->json(['errors' => 
                    'New password cannot be same as your current password. Please choose a different new password'], 403);
            }

            $user->password = Hash::make($request->input('newPassword'));
            $user->save();

            ActivityLog::create([
                'type' => 'Password Changed',
                'remarks' => sprintf('%s(%d) account password changed',$user->name, $user->id),
                'model' => 'User',
                'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
            ]);

            return response()->json(['message' => 'Your account has been updated'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->isAdmin()) {
            return response()->json(['error' => 'Ehhh! Can not retire admin user'], 403);
        }

        try {
            $user->retire = $user->retire == 0 ? 1 : 0;
            $user->save();

            ActivityLog::create([
                'type' => 'User Retired',
                'remarks' => sprintf('%s(%d) status retired',$user->name, $user->id),
                'model' => 'User',
                'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
            ]);

            return new UserResource($user);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 403);
        }
    }

    /**
     * Get permissions from role
     *
     * @param User $user
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function permissions(User $user)
    {
        try {
            return new JsonResponse([
                'user' => PermissionResource::collection($user->getDirectPermissions()),
                'role' => PermissionResource::collection($user->getPermissionsViaRoles()),
            ]);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }

    /**
     * @param bool $isNew
     * @return array
     */
    private function getValidationRules($isNew = true)
    {
        return [
            'name' => 'required',
            'email' => $isNew ? 'required|email|unique:users' : 'required|email',
            'roles' => [
                'required',
                'array'
            ],
        ];
    }

    /**
     * @param bool $isNew
     * @return array
     */
    private function getAccountValidationRules($isAdmin = false)
    {
        return [
            'password' => $isAdmin ? 'string' : 'required|string',
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'same:newPassword',
        ];
    }

    public function requestedRoles(Request $request){
        $users = User::where('requested_role', '!=', NULL)->get();
        return UserResource::collection($users);
    }

    public function approveRequestedRole(Request $request){
        $user = User::find($request->id);
        $role = Role::findByName($user->requested_role);
        $user->syncRoles($role);

        ActivityLog::create([
            'type' => 'Role Approve',
            'remarks' => sprintf('%s(%d), %s requested role approved',$user->name, $user->id, $user->requested_role),
            'model' => 'User',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        $user->requested_role = NULL;
        $user->save();

        return new UserResource($user);
    }

    public function removeRequestedRole(User $user){
        $user->requested_role = NULL;
        $user->save();
        return new UserResource($user);
    }
}
