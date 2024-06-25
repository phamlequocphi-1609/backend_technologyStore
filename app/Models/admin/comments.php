<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $table = 'comments';
  
    protected $fillable = [
        'id_blog', 'id_user', 'name_user', 'avatar_user', 'comment', 'id_comment'
    ];
}