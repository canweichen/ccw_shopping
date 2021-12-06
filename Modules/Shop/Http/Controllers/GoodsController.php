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
        $data = $this->goodsService->getGoodsList();
        return $this->success($data);
    }

    public function showGoodsDetail(Request $request,$goodsId): array
    {
        return $this->success($request->all());
    }

    public function createGoods(Request $request): array
    {
        return $this->success($request->all());
    }

    public function editGoods(Request $request,$goodsId): array
    {
        return $this->success($request->all());
    }

    public function deleteGoods(Request $request,$goodsId): array
    {
        return $this->success($request->all());
    }
}
