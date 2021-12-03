<?php
namespace Modules\Shop\Http\Services;

use Modules\Shop\Http\Repositories\GoodsRepository;

class GoodsService{
    protected $goodsRepository;
    public function __construct(GoodsRepository $goodsRepository){
        $this->goodsRepository = $goodsRepository;
    }

    public function getGoodsList(): array
    {
        return $this->goodsRepository->getGoodsList();
    }
}
