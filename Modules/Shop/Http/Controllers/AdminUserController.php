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

    public function showGoodsList(Request $request): array
    {
        $name = $request->input('name','');
        $type = $request->input('type',0);
        $limit = $request->input('limit',10);
        $data = [];
        return $this->success($data);
    }

    public function showGoodsDetail($adminUserId): array
    {
        if($adminUserId <= 0){
            return $this->errors('管理员不存在');
        }
        $info = [];
        return $this->success($info);
    }

    public function createGoods(Request $request): array
    {
        return $this->success($request->all());
    }

    public function editGoods(Request $request,$goodsId): array
    {
        return $this->success($request->all());
    }

    public function deleteGoods($goodsId): array
    {
        if($goodsId <= 0){
            return $this->errors('管理员不存在');
        }
        $result = [];
        if(!$result){
            return $this->errors('商品删除失败');
        }
        return $this->success();
    }
}
