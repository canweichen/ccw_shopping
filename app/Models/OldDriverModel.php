<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldDriverModel extends Model{
    protected $primaryKey = 'id';
    protected $table = 'old_driver';
    protected $timestamp = false;
}
