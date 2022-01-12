<?php
namespace App\Utils;

class ArrayUtil{
    public static function compareArray(array $a,array $b):array{
        //common part
        $commonArray = array_intersect($a,$b);
        //a - b
        $diffA = array_diff($a,$b);
        //b - a
        $diffB = array_diff($b,$a);
        return ['common' => $commonArray,'diffA' => $diffA, 'diffB' => $diffB];
    }
}
