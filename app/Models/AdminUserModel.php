<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUserModel extends Model{

    protected $primaryKey = 'admin_user_id';
    protected $table = 'shop_admin_user';
    protected $timestamp = true;

}
