<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use \App\Laravue\Acl;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\FormDataController;
use App\Http\Controllers\Api\DigitalHealthProjectController;
use App\Http\Controllers\Api\EvaluateProjectController;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ApplicationPlatformController;
use App\Http\Controllers\Api\DataStandardController;
use App\Http\Controllers\Api\DbmsSupportController;
use App\Http\Controllers\Api\DeploymentLocationController;
use App\Http\Controllers\Api\DigitalHealthInterventionController; 
use App\Http\Controllers\Api\EhaComponentController; 
use App\Http\Controllers\Api\FacilityTypeController; 
use App\Http\Controllers\Api\HealthFocusAreaController; 
use App\Http\Controllers\Api\EvaluationMetricsCategoryController;
use App\Http\Controllers\Api\EvaluationMetricsController; 
use App\Http\Controllers\Api\HealthProfessionalGroupController;
use App\Http\Controllers\Api\HealthSystemChallengeController;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\OrganizationUnitController;
use App\Http\Controllers\Api\OSIApprovedLicenseController;
use App\Http\Controllers\Api\OsSupportController;
use App\Http\Controllers\Api\OwnershipTypeController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\ProgrammingLanguageController;
use App\Http\Controllers\Api\RegionController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\Api\ApplicationTypeController;






Route::namespace('Api')->group(function() {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    

    Route::get('registration/form-data', [FormDataController::class, 'getRegistrationData']);
    
    Route::get('resource', [ResourceController::class, 'index']);

    Route::get('search', [DigitalHealthProjectController::class, 'search']);

    Route::get('project/{uuid}', [DigitalHealthProjectController::class, 'getProjectWithUuid']);

    Route::get('projects/search-data', [FormDataController::class, 'getProjectSearchData']);
    
    Route::get('dashboard/get-totals', [DashboardController::class, 'getTotals']);
    Route::get('dashboard/eha-components-projects-count', [DashboardController::class, 'eHAComponentsProjectsCount']);
    Route::get('dashboard/regional-projects-count', [DashboardController::class, 'regionalProjectsCount']);
    Route::get('dashboard/top_lead_organizations', [DashboardController::class, 'topLeadOrganizations']);
    Route::get('dashboard/top_focus_areas', [DashboardController::class, 'topFocusAreas']);
    Route::get('dashboard/top_challenges', [DashboardController::class, 'topChallenges']);
    Route::get('dashboard/by_status', [DashboardController::class, 'projectsByStatus']);
    Route::get('dashboard/by_license', [DashboardController::class, 'projectsByLicense']);
    Route::get('dashboard/by_implementation', [DashboardController::class, 'projectsByImplementation']);
    Route::get('dashboard/top_partners', [DashboardController::class, 'topPartners']);
    Route::get('dashboard/by_dhi', [DashboardController::class, 'projectsByDhiType']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::post('auth/logout', [AuthController::class, 'logout']);

        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

       

        

        Route::get('projects', [DigitalHealthProjectController::class, 'index']);
        Route::post('projects', [DigitalHealthProjectController::class, 'store']);
               
        Route::get('projects/{project}', [DigitalHealthProjectController::class, 'show']);
        Route::delete('projects/{project}', [DigitalHealthProjectController::class, 'destroy']);
        Route::post('/projects/{id}/archive', [DigitalHealthProjectController::class, 'archive']);
        Route::post('projects/{id}/unarchive', [DigitalHealthProjectController::class, 'unarchive']);

        Route::post('projects/{project}/resource', [DigitalHealthProjectController::class, 'resource']);
        Route::post('projects/{project}/logo', [DigitalHealthProjectController::class, 'logo']);
        Route::post('projects/{project}/impact_evaluation', [DigitalHealthProjectController::class, 'impact_evaluation']);
        Route::delete('projects/{project}/type', [DigitalHealthProjectController::class, 'delete_type']);
        Route::put('projects/{project}/request_registration', [DigitalHealthProjectController::class, 'request_registration']);
        Route::put('projects/{project}/withdraw_registration', [DigitalHealthProjectController::class, 'withdraw_registration']);
        Route::put('projects/{project}/request_cert_comp', [DigitalHealthProjectController::class, 'request_cert_comp']);
        
        Route::get('evaluation', [EvaluateProjectController::class, 'index']);
        Route::post('evaluation/approve_registration/{project}', [EvaluateProjectController::class, 'approve_registration']);
        Route::post('evaluation/cert_competence/{project}', [EvaluateProjectController::class, 'cert_competence']);

        Route::get('evaluation/decline_messages/{project}', [EvaluateProjectController::class, 'decline_messages']);
        Route::post('evaluation/decline_registration/{project}', [EvaluateProjectController::class, 'decline_registration']);
        Route::post('evaluation/decline_cert_comp/{project}', [EvaluateProjectController::class, 'decline_cert_comp']);

        Route::put('users/{user}', [UserController::class, 'update']);

        // Change Password
        Route::put('users/{user}/change-password', [UserController::class, 'changePassword']);
    });

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('user/role-request', [UserController::class, 'requestedRoles']);
        Route::post('user/role-request', [UserController::class, 'approveRequestedRole']);
        Route::delete('user/role-request/{user}', [UserController::class, 'removeRequestedRole']);

        Route::post('resource', [ResourceController::class, 'store']);

        // Api resource routes
        Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        
        // Permission routes
        Route::get('permissions', [PermissionController::class, 'index'])->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // User routes
        Route::get('users', [UserController::class, 'index'])->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::post('users', [UserController::class, 'store'])->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::get('users/{user}', [UserController::class, 'show'])->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);

        // Custom routes
        Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::put('users/{user}/permissions', [UserController::class, 'requestedRoles'])->middleware('permission:' .Acl::PERMISSION_PERMISSION_MANAGE);
        Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);   
    });
});
    // Admin routes
Route::group(['middleware' => 'role:admin'], function () {
    Route::apiResource('application-platforms', ApplicationPlatformController::class);
    Route::apiResource('data-standards', DataStandardController::class);
    Route::apiResource('dbms-supports', DbmsSupportController::class);
    Route::apiResource('deployment-locations', DeploymentLocationController::class);
    Route::apiResource('digital-health-intervention', DigitalHealthInterventionController::class);
   
    Route::apiResource('facility-type', FacilityTypeController::class);
    Route::apiResource('health-focus-area', HealthFocusAreaController::class);
    Route::apiResource('evaluation-metrics-category', EvaluationMetricsCategoryController::class);
    Route::apiResource('evaluation-metrics', EvaluationMetricsController::class);
    Route::apiResource('health-professional-groups', HealthProfessionalGroupController::class);
    Route::apiResource('health-system-challenges', HealthSystemChallengeController::class);
    Route::apiResource('licenses', LicenseController::class);
    Route::apiResource('organization-units', OrganizationUnitController::class);
    Route::apiResource('osi-approved-licenses', OSIApprovedLicenseController::class);
    Route::apiResource('os-supports', OsSupportController::class);
    Route::apiResource('ownership-types', OwnershipTypeController::class);
    Route::apiResource('partners', PartnerController::class);
    Route::apiResource('programming-languages', ProgrammingLanguageController::class);
    Route::apiResource('regions', RegionController::class);

    Route::apiResource('eha-component', EhaComponentController::class);
    Route::apiResource('application-types', ApplicationTypeController::class);
    Route::apiResource('activity-logs', ActivityLogController::class)->only(['index', 'show']);

});
    