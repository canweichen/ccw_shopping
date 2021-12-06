<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopGoods extends Model{
    protected $primaryKey = 'gid';
    protected $table = 'shop_goods';
    protected $timestamp = false;
}
