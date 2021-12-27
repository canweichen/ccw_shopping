<?php
namespace Modules\Shop\Http\Services;

use App\Utils\CabinRuleAdapterUtil;
use Modules\Shop\Http\Repositories\ShopPermissionRepository;
use Modules\Shop\Http\Repositories\ShopRoleRepository;

class CabinRuleService{

    public function assignRoleForUser($adminUserId,array $roleIds):bool{
        if($adminUserId <= 0 || count($roleIds) <= 0){
            return false;
        }
        //assign role
        $roleIds = app(ShopRoleRepository::class)->getShopRolesByIds($roleIds);
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
        if(count($currentRole) > 0){
            //delete role
            $isDeleteOk = CabinRuleAdapterUtil::deleteRolesForUser($adminUserId);
            if(!$isDeleteOk){
                return false;
            }
        }
        //reload assign role for user
        return $this->assignRoleForUser($adminUserId,$roleIds);
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
        if(!empty($currentPermissions)){
            //remove permission under the role
            $isDeleteOk = CabinRuleAdapterUtil::deletePermissionsForRole($roleId);
            if(!$isDeleteOk){
                return false;
            }
        }
        //reload assign permission for the role
        return $this->assignPermissionForRole($roleId,$permissionIds);
    }
}
