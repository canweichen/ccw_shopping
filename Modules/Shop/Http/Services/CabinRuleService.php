<?php
namespace Modules\Shop\Http\Services;

use App\Utils\ArrayUtil;
use App\Utils\CabinRuleAdapterUtil;
use Modules\Shop\Http\Repositories\ShopPermissionRepository;
use Modules\Shop\Http\Repositories\ShopRoleRepository;

class CabinRuleService{

    public function assignRoleForUser($adminUserId,array $roleIds):bool{
        if($adminUserId <= 0 || count($roleIds) <= 0){
            return false;
        }
        //assign role
        $roleArr = app(ShopRoleRepository::class)->getShopRolesByIds($roleIds);
        $roleIds = array_column($roleArr,'role_id');
        if(!empty($roleIds)){
            return CabinRuleAdapterUtil::addRolesForUser($adminUserId,$roleIds);
        }
        return false;
    }

    public function updateRoleForUser($adminUserId,array $roleIds):bool{
        if($adminUserId <= 0){
            return false;
        }
        //Has roles for the user
        $currentRole = CabinRuleAdapterUtil::getRolesForUser($adminUserId);
        //filter common
        $roleArr = ArrayUtil::compareArray($roleIds,$currentRole);
        if(!empty($roleArr['delete'])){
            //delete role
            $isDeleteOk = CabinRuleAdapterUtil::deleteRolesAboutUser($adminUserId,$roleArr['delete']);
            if(!$isDeleteOk){
                return false;
            }
        }
        //reload assign role for user
        if(!empty($roleArr['new'])){
            $this->assignRoleForUser($adminUserId,$roleArr['new']);
        }
        return true;
    }

    public function assignPermissionForRole($roleId,array $permissionIds):bool{
        if($roleId <= 0 || count($permissionIds) <= 0){
            return false;
        }
        //assign permission
        $permissions = app(ShopPermissionRepository::class)->getShopPermissionsByIds($permissionIds);
        if(!empty($permissions)){
            return CabinRuleAdapterUtil::addPermissionsForRole($roleId,$permissions);
        }
        return false;
    }

    public function updatePermissionForRole($roleId,array $permissionIds):bool{
        if($roleId <= 0 ){
            return false;
        }
        //Has permission for the role
        $currentPermissions = CabinRuleAdapterUtil::getPermissionsForRole($roleId);
        //Filter permission
        $permissionArr = ArrayUtil::compareArray($permissionIds,array_column($currentPermissions,1));
        if(!empty($permissionArr['delete'])){
            //remove permission under the role
            $isDeleteOk = CabinRuleAdapterUtil::deletePermissionsAboutRole($roleId,$permissionArr['delete']);
            if(!$isDeleteOk){
                return false;
            }
        }
        //reload assign permission for the role
        if(!empty($permissionArr['new'])){
            $this->assignPermissionForRole($roleId,$permissionIds);
        }
        return true;
    }

    public static function getMenuList(int $adminUserId):array{
        $data = ['role' => [],'permission' => []];
        //获取角色
        $currentRoleIds = CabinRuleAdapterUtil::getRolesForUser($adminUserId);
        if(empty($currentRoleIds)){
            return $data;
        }
        $data['role'] = app(ShopRoleRepository::class)->getShopRolesByIds($currentRoleIds);
        //角色下权限
        $permissionIds = [];
        foreach($data['role'] as $item){
            $permission = CabinRuleAdapterUtil::getPermissionsForRole($item['role_id']);
            $permissionIds = array_merge($permissionIds,array_column($permission,1));
        }
        $permissionIds = array_unique($permissionIds);
        //解析子权限
        $permissionInstance = app(ShopPermissionRepository::class);
        $permissionArr = $permissionInstance->getShopPermissionsByIds($permissionIds);
        //获取父级权限菜单
        $parentIds = array_unique(array_column($permissionArr,'permission_parent'));
        $data['permission'] = $permissionInstance->getShopPermissionsByIds($parentIds);
        return $data;
    }
}
