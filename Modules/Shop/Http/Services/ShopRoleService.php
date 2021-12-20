<?php
namespace Modules\Shop\Http\Services;

use Modules\Shop\Http\Repositories\ShopRoleRepository;

class ShopRoleService{
    public $roleRepository;
    public function __construct(ShopRoleRepository $roleRepository){
        $this->roleRepository = $roleRepository;
    }

    public function getShopRoleList(string $roleName,int $limit):array{
        return $this->roleRepository->getShopRoles($roleName,$limit);
    }

    public function getShopRoleDetail(int $roleId):array{
        return $this->roleRepository->getShopRolesById($roleId);
    }

    public function addShopRole(array $role):array{
        $roleDetail = $this->roleRepository->getShopRolesByName($role['role_name']);
        if(empty($roleDetail)){
            return simpleResponse(500,'角色名称重复');
        }
        $result = $this->roleRepository->addShopRoles($role);
        if(!$result){
            return simpleResponse(500,'角色添加失败');
        }
        return simpleResponse(200,'角色添加成功');
    }

    public function updateShopRole(array $role):array{
        $info = $this->roleRepository->getShopRolesById($role['role_id']);
        if(empty($info)){
            return simpleResponse(500,'角色不存在');
        }
        if($info['role_name'] != $role['role_name']){
            $roleDetail = $this->roleRepository->getShopRolesByName($role['role_name']);
            if(empty($roleDetail)){
                return simpleResponse(500,'角色名称重复');
            }
        }
        $result = $this->roleRepository->updateShopRoles($role);
        if(!$result){
            return simpleResponse(500,'角色更新失败');
        }
        return simpleResponse(200,'角色更新成功');
    }

    public function deleteShopRole(int $roleId):array{
        $info = $this->roleRepository->getShopRolesById($roleId);
        if(empty($info)){
            return simpleResponse(200,'角色删除成功');
        }
        $result = $this->deleteShopRole($roleId);
        if(!$result){
            return simpleResponse(500,'角色删除失败');
        }
        return simpleResponse(200,'角色删除成功');
    }
}
