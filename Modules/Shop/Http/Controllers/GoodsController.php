<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\GoodsService;

class GoodsController extends BaseController {
    protected $goodsService;

    public function __construct(GoodsService $goodsService){
        $this->goodsService = $goodsService;
    }

    public function showGoodsList(Request $request): array
    {
        $name = $request->input('name','');
        $type = $request->input('type',0);
        $limit = $request->input('limit',10);
        $data = $this->goodsService->getGoodsList($name,$type,$limit);
        return $this->success($data);
    }

    public function showGoodsDetail($goodsId): array
    {
        if($goodsId <= 0){
            return $this->errors('商品不存在');
        }
        $info = $this->goodsService->getGoodsDetail($goodsId);
        if(empty($info)){
            return $this->errors('商品不存在');
        }
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
            return $this->errors('商品不存在');
        }
        $result = $this->goodsService->deleteGoods($goodsId);
        if(!$result){
            return $this->errors('商品删除失败');
        }
        return $this->success();
    }
}
