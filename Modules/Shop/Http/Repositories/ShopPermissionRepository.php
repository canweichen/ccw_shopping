<?php
namespace Modules\Shop\Http\Repositories;

use App\Models\ShopPermissions;

class ShopPermissionRepository{

    public function getShopPermissions(string $permissionName,int $limit): array
    {
        $collect = ShopPermissions::where('permission_status','>=',0)
            ->when(!empty($permissionName),function($query) use($permissionName){
                return $query->where('permission_name','LIKE',"%{$permissionName}%");
            })
            ->orderByDesc('permission_id')
            ->simplePaginate($limit);
        return objectToArray($collect);
    }

    public function getShopPermissionsById(int $permissionId): array
    {
        if($permissionId <= 0){
            return [];
        }
        $collect = ShopPermissions::where('permission_status','>=',0)
            ->where('permission_id',$permissionId)
            ->first();
        return objectToArray($collect);
    }

    public function getShopPermissionsByIds(array $permissionIds): array
    {
        if(count($permissionIds) <= 0){
            return [];
        }
        $collect = ShopPermissions::select('permission_id','permission_method')
            ->where('permission_status','>=',0)
            ->whereIn('permission_id',$permissionIds)
            ->get();
        return objectToArray($collect);
    }

    public function getShopPermissionsByUrl(string $url): array
    {
        if(empty($url)){
            return [];
        }
        $collect = ShopPermissions::where('permission_status','>=',0)
            ->where('permission_url',$url)
            ->first();
        return objectToArray($collect);
    }

    public function getShopPermissionsByName(string $permissionName): array
    {
        if(empty($permissionName)){
            return [];
        }
        $collect = ShopPermissions::where('permission_status','>=',0)
            ->where('permission_name',$permissionName)
            ->first();
        return objectToArray($collect);
    }

    public function addShopPermissions(array $permissions):int{
        if(empty($permissions['permission_name'])){
            return 0;
        }
        $data = [
            'permission_name' => $permissions['permission_name'],
            'permission_url'  => $permissions['permission_url'],
            'permission_method' => $permissions['permission_method'],
            'permission_status' => $permissions['permission_status']
        ];
        return ShopPermissions::insertGetId($data);
    }

    public function updateShopPermissions(array $permissions):bool{
        if(empty($permissions['permission_name']) || empty($permissions['permission_id'])){
            return false;
        }
        $data = [
            'permission_name' => $permissions['permission_name'],
            'permission_url'  => $permissions['permission_url'],
            'permission_method' => $permissions['permission_method'],
            'permission_status' => $permissions['permission_status']
        ];
        return ShopPermissions::where('permission_id',$permissions['permission_id'])->update($data);
    }

    public function deleteShopPermissions(int $permissionId):bool{
        if($permissionId <= 0){
            return false;
        }
        return ShopPermissions::where('permission_id',$permissionId)->update(['permission_status' => -1]);
    }
}
