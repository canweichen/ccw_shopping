<?php
namespace App\Utils;

class ArrayUtil{
    public static function compareArray(array $newArr,array $oldArr):array{
        $data = array();
        //common part
        $data['common'] = array_intersect($newArr,$oldArr);
        //a - b
        $data['new'] = array_diff($newArr,$oldArr);
        //b - a
        $data['delete'] = array_diff($oldArr,$newArr);
        return $data;
    }
}
