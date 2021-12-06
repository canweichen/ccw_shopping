<?php
namespace Modules\Shop\Http\Services;

use Illuminate\Http\Request;
use Modules\Shop\Http\Repositories\GoodsRepository;

class GoodsService{
    protected $goodsRepository;
    protected $request;
    public function __construct(GoodsRepository $goodsRepository,Request $request){
        $this->goodsRepository = $goodsRepository;
        $this->request = $request;
    }

    public function getGoodsList(): array
    {
        $name = $this->request->input('name','');
        $type = $this->request->input('type',0);
        $limit = $this->request->input('limit',10);
        return $this->goodsRepository->getGoodsList($name,$type,$limit);
    }
}
