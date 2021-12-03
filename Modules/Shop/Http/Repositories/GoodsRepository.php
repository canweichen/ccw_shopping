<?php
namespace Modules\Shop\Http\Repositories;

use App\Models\OldDriverModel;
use App\Utils\ArrayUtil;

class GoodsRepository{

    public function getGoodsList(): array
    {
        $collect = OldDriverModel::whereBetween('id',[10,100])
            ->get();
        return ArrayUtil::ObjectToArray($collect);
    }
}
