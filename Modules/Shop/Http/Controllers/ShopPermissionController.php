<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\ShopPermissionService;

class ShopPermissionController extends BaseController{
    public $shopPermissionService;
    public function __construct(ShopPermissionService $shopPermissionService){
        $this->shopPermissionService = $shopPermissionService;
    }

    public function getShopPermissionList(Request $request):array{
        $permissionName = $request->input('name','');
        $limit = $request->input('limit',10);
        return $this->success($this->shopPermissionService->getShopPermissionList($permissionName,$limit));
    }

    public function getShopPermissionDetail($permissionId):array{
        return $this->success($this->shopPermissionService->getShopPermissionDetail($permissionId));
    }

    public function addShopPermission(Request $request):array{
        $permission = $request->only(['permission_id','permission_name','permission_url','permission_method','permission_status']);
        $result = $this->shopPermissionService->addShopPermission($permission);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }

    public function updateShopPermission(Request $request,$permissionId):array{
        $permission = $request->only(['permission_id','permission_name','permission_url','permission_method','permission_status']);
        $permission['permission_id'] = $permissionId;
        $result = $this->shopPermissionService->updateShopPermission($permission);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }

    public function deleteShopPermission($permissionId):array{
        $result = $this->shopPermissionService->deleteShopPermission($permissionId);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }
}
