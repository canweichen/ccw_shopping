<?php
namespace Modules\Admin\Common;

class ArrayUtil{
    
    public static function arrayToString(array $array,string $explode):string{
        return implode($explode,$array);
    }
}