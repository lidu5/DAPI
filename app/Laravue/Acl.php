<?php
/**
 * File Acl.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Laravue;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Acl
 *
 * @package App\Laravue
 */
final class Acl
{
    const ROLE_ADMIN = 'admin';
    const ROLE_QA_APPROVER = 'qa_approver';
    const ROLE_REG_APPROVER = 'reg_approver';
    const ROLE_IMPLEMENTER = 'implementer';
    const ROLE_VISITOR = 'visitor';

    const PERMISSION_USER_MANAGE = 'manage user';
    const PERMISSION_ROLE_MANAGE = 'manage role';
    const PERMISSION_PERMISSION_MANAGE = 'manage permission';

    const PERMISSION_MANAGE_SELF_PROFILE = 'manage self profile';

    const PERMISSION_APPROVE_REQUESTED_ROLE = 'approve requested role';
    
    const PERMISSION_VIEW_PROJECTS = 'view projects';
    const PERMISSION_ADD_PROJECT = 'add project';
    const PERMISSION_EDIT_PROJECT = 'edit project';
    const PERMISSION_VIEW_PROJECT = 'view project';
    const PERMISSION_DELETE_PROJECT = 'delete project';

    const PERMISSION_DELETE_PROJECT_TYPES = 'delete project type';
    
    const PERMISSION_REQUEST_CERT_REGISTRATION = 'request cert registration';
    const PERMISSION_CERT_REGISTRATION = 'cert registration';
    const PERMISSION_REQUEST_CERT_COMPETENCE = 'request cert competence';
    const PERMISSION_CERT_COMPETENCE = 'cert competence';

    const PERMISSION_PROJECT_EVALUATION = 'project evaluation';

    /**
     * @param array $exclusives Exclude some permissions from the list
     * @return array
     */
    public static function permissions(array $exclusives = []): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function($value, $key) use ($exclusives) {
                return !in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    /**
     * @return array
     */
    public static function roles(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles =  Arr::where($constants, function($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}
