<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Laravue\Models\Role;
use App\Laravue\Models\Permission;
use App\Laravue\Acl;

class SetupRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Acl::roles() as $role) {
            Role::findOrCreate($role);
        }

        $admin = Role::findByName(Acl::ROLE_ADMIN);
        $qa_approver = Role::findByName(Acl::ROLE_QA_APPROVER);
        $reg_approver = Role::findByName(Acl::ROLE_REG_APPROVER);
        $implementer = Role::findByName(Acl::ROLE_IMPLEMENTER);
        $visitor = Role::findByName(Acl::ROLE_VISITOR);
        
        foreach (Acl::permissions() as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        // Setup basic permission
        $admin->givePermissionTo(Acl::permissions());
        
        $qa_approver->givePermissionTo(
            [
                Acl::PERMISSION_CERT_COMPETENCE,
                Acl::PERMISSION_MANAGE_SELF_PROFILE,
                Acl::PERMISSION_VIEW_PROJECT,
                Acl::PERMISSION_PROJECT_EVALUATION
            ]);
        $reg_approver->givePermissionTo(
            [
                Acl::PERMISSION_CERT_REGISTRATION,
                Acl::PERMISSION_MANAGE_SELF_PROFILE,
                Acl::PERMISSION_VIEW_PROJECT,
            ]);
        $implementer->givePermissionTo(
            [
                Acl::PERMISSION_ADD_PROJECT,
                Acl::PERMISSION_VIEW_PROJECTS,
                Acl::PERMISSION_EDIT_PROJECT,
                Acl::PERMISSION_VIEW_PROJECT,
                Acl::PERMISSION_REQUEST_CERT_REGISTRATION,
                Acl::PERMISSION_REQUEST_CERT_COMPETENCE,
                Acl::PERMISSION_MANAGE_SELF_PROFILE
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('representative');
            });
        }

        /** @var \App\User[] $users */
        $users = \App\Laravue\Models\User::all();
        foreach ($users as $user) {
            $roles = array_reverse(Acl::roles());
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    $user->role = $role;
                    $user->save();
                }
            }
        }
    }
}
