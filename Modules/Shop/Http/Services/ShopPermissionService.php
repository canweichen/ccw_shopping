<?php
namespace Modules\Shop\Http\Services;

use Modules\Shop\Http\Repositories\ShopPermissionRepository;

class ShopPermissionService{
    public $permissionRepository;
    public function __construct(ShopPermissionRepository $permissionRepository){
        $this->permissionRepository = $permissionRepository;
    }

    public function getShopPermissionList(string $permissionName,int $limit):array{
        return $this->permissionRepository->getShopPermissions($permissionName,$limit);
    }

    public function getShopPermissionDetail(int $permissionId):array{
        return $this->permissionRepository->getShopPermissionsById($permissionId);
    }

    public function getShopPermissionDetailByUrl(string $url):array{
        return $this->permissionRepository->getShopPermissionsByUrl($url);
    }

    public function addShopPermission(array $permission):array{
        $permissionDetail = $this->permissionRepository->getShopPermissionsByName($permission['permission_name']);
        if(empty($permissionDetail)){
            return simpleResponse(500,'权限名称重复');
        }
        $result = $this->permissionRepository->addShopPermissions($permission);
        if(!$result){
            return simpleResponse(500,'权限添加失败');
        }
        return simpleResponse(200,'权限添加成功');
    }

    public function updateShopPermission(array $permission):array{
        $info = $this->permissionRepository->getShopPermissionsById($permission['permission_id']);
        if(empty($info)){
            return simpleResponse(500,'权限不存在');
        }
        if($info['permission_name'] != $permission['permission_name']){
            $permissionDetail = $this->permissionRepository->getShopPermissionsByName($permission['permission_name']);
            if(empty($permissionDetail)){
                return simpleResponse(500,'权限名称重复');
            }
        }
        $result = $this->permissionRepository->updateShopPermissions($permission);
        if(!$result){
            return simpleResponse(500,'权限更新失败');
        }
        return simpleResponse(200,'权限更新成功');
    }

    public function deleteShopPermission(int $permissionId):array{
        $info = $this->permissionRepository->getShopPermissionsById($permissionId);
        if(empty($info)){
            return simpleResponse(200,'权限删除成功');
        }
        $result = $this->deleteShopPermission($permissionId);
        if(!$result){
            return simpleResponse(500,'权限删除失败');
        }
        return simpleResponse(200,'权限删除成功');
    }

    public function getPermissionTrees():array{
        //permission header
        $permissions = $this->permissionRepository->getShopPermissions('',-9999);
        //permission body
        $permissions = collect($permissions);
        $permissionTrees = $permissions->where('permission_parent',0)->all();
        foreach($permissionTrees as $key => $permission){
            $permissionTrees[$key]['child'] = $permissions->where('permission_parent',$permission['permission_id'])->all();
        }
        return $permissionTrees;
    }
}
