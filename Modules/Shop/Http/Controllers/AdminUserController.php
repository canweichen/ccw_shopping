<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\AdminUserService;

class AdminUserController extends BaseController{
    protected $adminUserService;

    public function __construct(AdminUserService $adminUserService){
        $this->adminUserService = $adminUserService;
    }

    public function showAdminUserList(Request $request): array
    {
        $username = $request->input('username','');
        $mobile = $request->input('mobile','');
        $email = $request->input('email','');
        $limit = $request->input('limit',10);
        $data = $this->adminUserService->getAdminUserList($username,$mobile,$email,$limit);
        return $this->success($data);
    }

    public function showAdminUserDetail($adminUserId): array
    {
        if($adminUserId <= 0){
            return $this->errors('管理员不存在');
        }
        $info = $this->adminUserService->getAdminUserDetail($adminUserId);
        if(empty($info)){
            return $this->errors('管理员不存在');
        }
        return $this->success($info);
    }

    public function createAdminUser(Request $request): array
    {
        return $this->success($request->all());
    }

    public function editAdminUser(Request $request,$goodsId): array
    {
        return $this->success($request->all());
    }

    public function deleteAdminUser($adminUserId): array
    {
        if($adminUserId <= 0){
            return $this->errors('管理员不存在');
        }
        $result = $this->adminUserService->deleteAdminUser($adminUserId);
        if(!$result){
            return $this->errors('管理员删除失败');
        }
        return $this->success();
    }

    public function restoreAdminUser($adminUserId): array
    {
        if($adminUserId <= 0){
            return $this->errors('管理员不存在');
        }
        $result = $this->adminUserService->restoreAdminUser($adminUserId);
        if(!$result){
            return $this->errors('管理员复职失败');
        }
        return $this->success();
    }

}
