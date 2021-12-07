<?php
namespace App\Http\Controllers;


class BaseController extends Controller{
    /**
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    public function success(array $data = [],int $code = 200,string $message = 'success'): array
    {
        return simpleResponse($code,$message,$data);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return array
     */
    public function errors(string $message,array $data = [],int $code = 500): array
    {
        return simpleResponse($code,$message,$data);
    }

}
