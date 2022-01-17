<?php
namespace App\Utils;

use Casbin\Enforcer;
use CasbinAdapter\DBAL\Adapter;
use Illuminate\Support\Facades\Facade;

class CabinRuleAdapterUtil extends Facade {

    public static function getEnforce(): Enforcer
    {
        $adapter = Adapter::newAdapter(config('database.connections.cabin_mysql'));
        return new Enforcer(config_path('rbac-model.conf'),$adapter);
    }

    public static function getRolesForUser($adminUserId):array{
        $sub = getCabinSub($adminUserId);
        $roles = self::getEnforce()->getRolesForUser($sub);
        return removeLetters($roles,'R');
    }

    public static function getImplicitRolesForUser($adminUserId):array{
        $sub = getCabinSub($adminUserId);
        $roles = self::getEnforce()->getImplicitRolesForUser($sub);
        return removeLetters($roles,'R');
    }

    public static function getUserForRole($roleId):array{
        $rol = getCabinRole($roleId);
        $roles = self::getEnforce()->getUsersForRole($rol);
        return removeLetters($roles,'U');
    }

    public static function hasRoleForUser($adminUserId,$roleId):bool{
        $sub = getCabinSub($adminUserId);
        $rol = getCabinRole($roleId);
        return self::getEnforce()->hasRoleForUser($sub,$rol);
    }

    public static function addRoleForUser($adminUserId,$roleId): bool
    {
        $sub = getCabinSub($adminUserId);
        $rol = getCabinRole($roleId);
        return self::getEnforce()->addRoleForUser($sub,$rol);
    }

    public static function addRolesForUser($adminUserId,$roleIds): bool
    {
        $sub = getCabinSub($adminUserId);
        $newRoleIds = [];
        foreach($roleIds as $roleId){
            array_push($newRoleIds,getCabinRole($roleId));
        }
        return self::getEnforce()->addRolesForUser($sub,$newRoleIds);
    }

    public static function deleteRoleForUser($adminUserId,$roleId): bool
    {
        $sub = getCabinSub($adminUserId);
        $rol = getCabinRole($roleId);
        return self::getEnforce()->deleteRoleForUser($sub,$rol);
    }

    public static function deleteRolesAboutUser($adminUserId,$roleIds): bool
    {
        try{
            foreach($roleIds as $roleId){
                self::deleteRoleForUser($adminUserId,$roleId);
            }
        }catch(\Exception $err){
            return false;
        }
        return true;
    }

    /**
     * @param $adminUserId
     * @return bool
     * @throws
     */
    public static function deleteRolesForUser($adminUserId): bool
    {
        //deleteRolesForUser 这个接口有bug
        $sub = getCabinSub($adminUserId);
        return self::getEnforce()->deleteRolesForUser($sub);
    }

    /**
     * Get permission for user
     * @param $adminUserId
     * @return array
     */
    public static function getPermissionsForUser($adminUserId): array
    {
        $sub = getCabinSub($adminUserId);
        $permissions = self::getEnforce()->getPermissionsForUser($sub);
        return removeLetters($permissions,'P');
    }

    public static function getPermissionsForRole($roleId): array
    {
        $rol = getCabinRole($roleId);
        $permissions = self::getEnforce()->getPermissionsForUser($rol);
        return removeLetters($permissions,'P');
    }

    public static function getImplicitPermissionsForUser($adminUserId): array
    {
        $sub = getCabinSub($adminUserId);
        $permissions = self::getEnforce()->getImplicitPermissionsForUser($sub);
        return removeLetters($permissions,'P');
    }

    public static function hasPermissionForUser($adminUserId,$permissionId): bool
    {
        $sub = getCabinSub($adminUserId);
        $obj = getCabinObj($permissionId);
        return self::getEnforce()->hasPermissionForUser($sub,$obj);
    }

    /**
     * Assign permission for role
     * @param $roleId
     * @param $permissionId
     * @param $act
     * @return bool
     */
    public static function addPermissionForRole($roleId,$permissionId,$act): bool
    {
        $rol = getCabinRole($roleId);
        $obj = getCabinObj($permissionId);
        return self::getEnforce()->addPermissionForUser($rol,$obj,$act);
    }

    public static function addPermissionsForRole($roleId,array $permissions): bool
    {
        if(count($permissions) < 1){
            return false;
        }
        foreach($permissions as $permission){
            self::addPermissionForRole($roleId,$permission['permission_id'],$permission['permission_method']);
        }
        return true;
    }

    public static function deletePermissionForRole($roleId,$permissionId): bool
    {
        $rol = getCabinRole($roleId);
        $obj = getCabinObj($permissionId);
        return self::getEnforce()->deletePermissionForUser($rol,$obj);
    }

    public static function deletePermissionsAboutRole($roleId,array $permissionIds): bool
    {
        try{
            foreach($permissionIds as $permissionId){
                self::deletePermissionForRole($roleId,$permissionId);
            }
        }catch(\Exception $err){
            return false;
        }
        return true;
    }

    public static function deletePermissionsForRole($roleId): bool
    {
        $rol = getCabinRole($roleId);
        return self::getEnforce()->deletePermissionsForUser($rol);
    }
}
