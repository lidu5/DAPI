<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Laravue\JsonResponse;
use App\Laravue\Acl;
use App\Laravue\Models\Role;
use App\Laravue\Models\User;
use App\Models\ActivityLog;
use Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json((new JsonResponse())->fail('Invalid email or password. Please try again.'), Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();

        if ($user->retire == 1) {
            return response()->json((new JsonResponse())->fail('Your account has been deactivated. Please contact support.'), Response::HTTP_FORBIDDEN);
        }

        ActivityLog::create([
            'type' => 'LOGIN',
            'remarks' => sprintf('%s(%d) signed in using %s email', $user->name, $user->id, $user->email),
            'model' => 'User',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return response()->json(new JsonResponse(new UserResource($user)), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                $this->getValidationRules(),
                [
                    'password' => ['required', 'min:6'],
                    'confirmPassword' => 'required|same:password',
                ]
            ),
            [
                'email.unique' => 'The email address is already in use. Please try another one.',
                'phoneNumber.unique' => 'The phone number is already registered. Use a different number.',
                'confirmPassword.same' => 'Passwords do not match. Please try again.',
                'password.min' => 'Password must be at least 6 characters long.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed. Please check the errors and try again.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $params = $request->all();


        $user = User::create([
            'name' => $params['firstName'] . ' ' . $params['middleName'] . ' ' . $params['lastName'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
            'work' => $params['work'] ?? null,
            'profession' => $params['profession'] ?? null,
            'address' => $params['address'] ?? null,
            'phone_number' => $params['phoneNumber'],
            'requested_role' => Acl::ROLE_IMPLEMENTER
        ]);
        
        $role = Role::findByName(Acl::ROLE_VISITOR);
        $user->syncRoles($role);

        ActivityLog::create([
            'type' => 'REGISTRATION',
            'remarks' => sprintf('%s(%d) registered with %s role', $user->name, $user->id, $user->requested_role),
            'model' => 'User',
            'user' => sprintf('%s(%d)', $user->name, $user->id)
        ]);

        return response()->json(new JsonResponse(new UserResource($user)), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $name = Auth::user()->name;

        Auth::guard('web')->logout();

        ActivityLog::create([
            'type' => 'LOGOUT',
            'remarks' => '',
            'model' => 'User',
            'user' => $name
        ]);

        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }

    /**
     * Validation rules for user registration
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'firstName' => 'required|string',
            'middleName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users',
            'phoneNumber' => 'required|unique:users,phone_number',
        ];
    }
}
