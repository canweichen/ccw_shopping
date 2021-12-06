<?php
namespace Modules\Shop\Http\Services;

use Illuminate\Http\Request;
use Modules\Shop\Http\Repositories\GoodsRepository;

class GoodsService{
    protected $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository){
        $this->goodsRepository = $goodsRepository;
    }

    public function getGoodsList($name,$type,$limit): array
    {
        return $this->goodsRepository->getGoodsList($name,$type,$limit);
    }

    public function getGoodsDetail($goodsId): array
    {

        return $this->goodsRepository->getGoodsDetail($goodsId);
    }

    public function deleteGoods($goodsId): bool
    {
        $info = $this->goodsRepository->getGoodsDetail($goodsId);
        if(empty($info)){
            return false;
        }
        $result = $this->goodsRepository->deleteGoods($goodsId);
        return !empty($result);
    }
}
