<?php
namespace Modules\Shop\Http\Repositories;

use App\Models\ShopRoles;

class ShopRoleRepository{
    public function getShopRoles(string $roleName,int $limit): array
    {
        $collect = ShopRoles::where('role_status','>=',0)
            ->when(!empty($roleName),function($query) use($roleName){
                return $query->where('role_name','LIKE',"%{$roleName}%");
            })
            ->orderByDesc('role_id')
            ->simplePaginate($limit);
        return objectToArray($collect);
    }

    public function getShopRolesById(int $roleId): array
    {
        if($roleId <= 0){
            return [];
        }
        $collect = ShopRoles::where('role_status','>=',0)
            ->where('role_id',$roleId)
            ->first();
        return objectToArray($collect);
    }

    public function getShopRolesByName(string $roleName): array
    {
        if(empty($roleName)){
            return [];
        }
        $collect = ShopRoles::where('role_status','>=',0)
            ->where('role_name',$roleName)
            ->first();
        return objectToArray($collect);
    }

    public function addShopRoles(array $roles):int{
        if(empty($roles['role_name'])){
            return 0;
        }
        $data = [
            'role_name' => $roles['role_name'],
            'role_status' => $roles['role_status']
        ];
        return ShopRoles::insertGetId($data);
    }

    public function updateShopRoles(array $roles):bool{
        if(empty($roles['role_name']) || empty($roles['role_id'])){
            return false;
        }
        $data = [
            'role_name' => $roles['role_name'],
            'role_status' => $roles['role_status']
        ];
        return ShopRoles::where('role_id',$roles['role_id'])->update($data);
    }

    public function deleteShopRoles(int $roleId):bool{
        if($roleId <= 0){
            return false;
        }
        return ShopRoles::where('role_id',$roleId)->update(['role_status' => -1]);
    }
}
