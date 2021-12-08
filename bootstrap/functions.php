<?php
/**
 * 将对象转化成数组
 * @param $object mixed
 * @return array
 */
if(!function_exists('objectToArray')){
    function objectToArray($object): array{
        if(empty($object)) return [];
        if(is_array($object)) return $object;
        return json_decode(json_encode($object),true);
    }
};
/**
 * 密码加密安全码
 * @return string
 */
if(!function_exists('getPasswordSalt')){
    function getPasswordSalt(): string {
        return time().mt_rand(100000,999999);
    }
}
/**
 * 密码加密
 * @param $password string
 * @param $salt string
 * @return string
 */
if(!function_exists('encodePassword')){
    function encodePassword($password,$salt):string{
        return md5(md5($salt.$password).$salt);
    }
}
/**
 * 手机号校验规则
 * @param $mobile string
 * @return boolean
 */
if(!function_exists('checkMobile')){
    function checkMobile($mobile):bool{
        if(!preg_match("/^1[0-9]{10}$/",$mobile)){
            return false;
        }
        return true;
    }
}
/**
 * 函数间数据返回模板
 */
if(!function_exists('simpleResponse')){
    function simpleResponse($code = 200,$message = '',$data = []):array{
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}

