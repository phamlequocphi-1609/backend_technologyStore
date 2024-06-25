<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    use HasFactory;
    protected $table = 'blog';  
    public $timestamp = true;    
    protected $fillable = [
        'title', 'image', 'description', 'content'
    ];
    public function comment(){
        return $this->hasMany('App\Models\admin\comments', 'id_blog');
    }
}