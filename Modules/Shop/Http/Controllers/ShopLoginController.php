<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\AdminUserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Casbin\Enforcer;
use CasbinAdapter\DBAL\Adapter;

class ShopLoginController extends BaseController{

    private $adminUserService;
    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function test(Request $request,$id): array{
       $adapter = Adapter::newAdapter([
           'driver' => 'pdo_mysql',
           'host' => 'localhost',
           'port' => '3306',
           'dbname' => 'demo',
           'user' => 'root',
           'password' => 'root',
       ]);
        //base_path().'/policy.csv'
        $enforcer = new Enforcer(base_path().'/model.conf',$adapter);
        $obj = $request->input('user','');
        $sub = $request->path();
        $act = $request->method();
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