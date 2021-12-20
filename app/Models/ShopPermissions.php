<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPermissions extends Model{
    protected $table = 'shop_permissions';
    protected $primaryKey = 'permission_id';
    public $created_at;
    public $updated_at;
}
