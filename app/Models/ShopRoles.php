<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ShopRoles extends Model{
    protected $table = 'shop_roles';
    protected $primaryKey = 'role_id';
    public $created_at;
    public $updated_at;
}
