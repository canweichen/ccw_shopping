<?php
namespace App\Utils;

class ArrayUtil{
    public static function compareArray(array $newArr,array $oldArr):array{
        //common part
        $commonArray = array_intersect($newArr,$oldArr);
        //a - b
        $new = array_diff($newArr,$oldArr);
        //b - a
        $delete = array_diff($oldArr,$newArr);
        return ['common' => $commonArray,'new' => $new, 'delete' => $delete];
    }
}
