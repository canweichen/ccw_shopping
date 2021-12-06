<?php

if(!function_exists('objectToArray')){
    function objectToArray($object): array{
        if(empty($object)) return [];
        if(is_array($object)) return $object;
        return json_decode(json_encode($object),true);
    }
};
