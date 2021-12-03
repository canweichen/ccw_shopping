<?php
namespace App\Utils;

class ResponseUtil{
    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    public static function success(array $data = [],int $code = 200,string $message = 'success'): array
    {
        return self::responseBody($code,$message,$data);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return array
     */
    public static function errors(string $message,array $data,int $code): array
    {
        return self::responseBody($code,$message,$data);
    }

    /**
     * @param $code
     * @param $message
     * @param $data
     * @return array
     */
    private static function responseBody($code,$message,$data):array{
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}
