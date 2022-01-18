<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Http\Services\AdminUserService;
use Modules\Shop\Http\Services\CabinRuleService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Utils\CabinRuleAdapterUtil;

class ShopLoginController extends BaseController{

    private $adminUserService;
    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function test(Request $request,$id): array{
        $enforcer = CabinRuleAdapterUtil::getEnforce();
        $obj = $request->input('user','');
        $sub = $request->path();
        $act = $request->method() == 'GET' ? 'read' : 'write';
        if($enforcer->enforce($obj, $sub, $act)){
            return $this->success([base_path(),$request->path(),$request->url(),$request->method(),$enforcer]);
        }
        return $this->errors('Forbidden',[base_path(),$request->path(),$request->url(),$request->method()],403);
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

    public function me(Request $request): array{
        //获取用户信息
        $adminUser = Auth::user();
        if(empty($adminUser['admin_user_id'])){
            return $this->errors('用户信息已失效，请重新登录...');
        }
        $data = [
            'user_id' => $adminUser['admin_user_id'],
            'user_name' => $adminUser['admin_user_name'],
            'user_nickname' => $adminUser['admin_user_nickname'] ?: '',
            'user_mobile' => $adminUser['admin_user_mobile'],
            'user_email' => $adminUser['admin_user_email']
        ];
        //获取菜单权限
        $data['permission'] = CabinRuleService::getMenuList($adminUser['admin_user_id']);

        return $this->success($data);
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
