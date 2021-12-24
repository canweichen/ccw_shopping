<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabinRuleModel extends Model{
    protected $table = 'casbin_rule';
    protected $primaryKey = 'id';
    protected $created_at;
    protected $updated_at;
}
