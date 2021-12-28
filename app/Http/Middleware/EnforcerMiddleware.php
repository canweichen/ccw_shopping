<?php

namespace App\Http\Middleware;

use App\Utils\CabinRuleAdapterUtil;
use Closure;
use Illuminate\Http\Request;
use Modules\Shop\Http\Services\ShopPermissionService;
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
        $permissionUrl = preg_replace(['/{/','/}/'],[':',''],$request->route()->uri);
        $permission = app(ShopPermissionService::class)->getShopPermissionDetailByUrl($permissionUrl);
        if(empty($permission)){
            return response(simpleResponse(500,'Permission not found',$permissionUrl));
        }
        $sub = getCabinSub($adminUserId);
        $obj = getCabinObj($permission['permission_id']);
        $act = getCabinAct($request->method());
        if(!CabinRuleAdapterUtil::getEnforce()->enforce($sub,$obj,$act)){
            return response(simpleResponse(403,'Forbidden'));
        }
        return $next($request);
    }
}
