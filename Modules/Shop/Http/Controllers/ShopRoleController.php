<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\ShopRoleService;

class ShopRoleController extends BaseController{

    public $roleService;
    public function __construct(ShopRoleService $roleService){
        $this->roleService = $roleService;
    }

    public function showShopRoleList(Request $request): array
    {
        $roleName = $request->input('name','');
        $limit = $request->input('limit',10);
        return $this->success($this->roleService->getShopRoleList($roleName,$limit));
    }

    public function showShopRoleDetail($roleId): array
    {
        return $this->success($this->roleService->getShopRoleDetail($roleId));
    }

    public function createShopRole(Request $request): array{
        $role = $request->only(['role_id','role_name','role_status']);
        $result = $this->roleService->addShopRole($role);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }

    public function editShopRole(Request $request,$roleId): array{
        $role = $request->only(['role_id','role_name','role_status']);
        $role['role_id'] = $roleId;
        $result = $this->roleService->updateShopRole($role);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }

    public function deleteShopRole($roleId): array{
        $result = $this->roleService->deleteShopRole($roleId);
        if($result['code'] == 200){
            return $this->success();
        }
        return $this->errors($result['message']);
    }
}
