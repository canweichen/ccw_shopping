<?php
namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Utils\ResponseUtil;
use Modules\Shop\Http\Services\GoodsService;
use App\Jobs\BatchSendSMS;

class GoodsController extends BaseController {
    protected $goodsService;

    public function __construct(GoodsService $goodsService){
        $this->goodsService = $goodsService;
    }

    public function showGoodsList(Request $request): array
    {
        $data = $this->goodsService->getGoodsList();
        dispatch(new BatchSendSMS())->onQueue('sms');
        return ResponseUtil::success($data);
    }

    public function showGoodsDetail(Request $request,$goodsId): array
    {
        return ResponseUtil::success($request->all());
    }

    public function createGoods(Request $request): array
    {
        return ResponseUtil::success($request->all());
    }

    public function editGoods(Request $request,$goodsId): array
    {
        return ResponseUtil::success($request->all());
    }

    public function deleteGoods(Request $request,$goodsId): array
    {
        return ResponseUtil::success($request->all());
    }
}
