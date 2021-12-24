<?php

namespace App\Http\Middleware;

use App\Utils\CabinRuleAdapterUtil;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnforcerMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Casbin\Exceptions\CasbinException
     */
    public function handle(Request $request, Closure $next)
    {
        $adminUserId = JWTAuth::parseToken()->getClaim('admin_user_id');
        if(empty($adminUserId)){
            return response(simpleResponse(500,'Token not found'));
        }
        $adminUserId = strval($adminUserId);
        $sub = $request->path();
        $act = $request->method() == 'GET' ? 'read' : 'write';
        if(!CabinRuleAdapterUtil::getEnforce()->enforce($adminUserId,$sub,$act)){
            return response(simpleResponse(403,'Forbidden'));
        }
        return $next($request);
    }
}
