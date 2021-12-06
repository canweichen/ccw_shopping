<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserModel extends Model{
    use softDeletes;
    protected $primaryKey = 'admin_user_id';
    protected $table = 'shop_admin_user';
    protected $created_at;
    protected $updated_at;
    protected $deleted_at;
}
