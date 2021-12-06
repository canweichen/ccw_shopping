<?php
namespace Modules\Shop\Http\Repositories;

use App\Models\ShopGoods;

class GoodsRepository{

    public function getGoodsList($name,$type,$limit): array
    {
        $collect = ShopGoods::when(!empty($name),function($query) use($name){
                return $query->where('title','like',"%{$name}%");
            })
            ->when(!empty($type),function($query) use($type){
                return $query->where('cid',$type);
            })
            ->orderBy('gid','desc')
            ->simplePaginate($limit);
        return objectToArray($collect);
    }

    public function getGoodsDetail($goodId): array
    {
        $collect = ShopGoods::find($goodId);
        return objectToArray($collect);
    }

    public function deleteGoods($goodId): bool
    {
        return ShopGoods::where('gid',$goodId)->delete();
    }
}
