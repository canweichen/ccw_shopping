<?php
namespace App\Utils;

use Casbin\Enforcer;
use CasbinAdapter\DBAL\Adapter;

class CabinRuleAdapterUtil{

    public static function getEnforce(): Enforcer
    {
        $adapter = Adapter::newAdapter(config('database.connections.cabin_mysql'));
        return new Enforcer(config_path('rbac-model.conf'),$adapter);
    }

}
