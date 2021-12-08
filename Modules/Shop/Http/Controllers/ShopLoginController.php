<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\AdminUserService;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopLoginController extends BaseController{

    private $adminUserService;
    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function login(Request $request): array
    {
        $mobile = $request->input('account','');
        $password = $request->input('password','');
        $result = $this->adminUserService->login($mobile,$password);
        if($result['code'] == 500){
            return $this->errors($result['message']);
        }
        return $this->success($result['data']);
    }

    public function logout():array
    {
        JWTAuth::parseToken()->invalidate();
        return $this->success();
    }

    public function refresh():array
    {
        $token = JWTAuth::parseToken()->refresh();
        return $this->success(['token' => $token]);
    }
}
