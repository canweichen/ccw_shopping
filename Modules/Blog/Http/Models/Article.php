<?php
namespace Modules\Blog\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    use HasFactory;
    
    protected $table = 'article';
    protected $primarykey = 'article_id';
    public $timestamp = fasle;
}