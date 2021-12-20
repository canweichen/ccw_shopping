<?php
namespace App\Utils;

use Casbin\Enforcer;
use CasbinAdapter\DBAL\Adapter;

class CasbinRuleAdapterUtil{

    public static function getEnforce(){
        $adapter = Adapter::newAdapter(config('database.connections.casbin_mysql'));
        return new Enforcer(base_path().'/model.conf',$adapter);
    }

}