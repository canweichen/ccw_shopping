<?php
namespace App\Http\Controllers;

use App\Utils\ResponseUtil;

class BaseController extends Controller{
    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    public function success(array $data = [],int $code = 200,string $message = 'success'): array
    {
        return self::responseBody($code,$message,$data);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return array
     */
    public function errors(string $message,array $data = [],int $code = 500): array
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
