<?php
namespace App\Utils;

class ArrayUtil{
    /**
     * @param $object
     * @return array
     */
    public static function ObjectToArray($object): array{
        if(empty($object)) return [];
        if(is_array($object)) return $object;
        return json_decode(json_encode($object),true);
    }
}
