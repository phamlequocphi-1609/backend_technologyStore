<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentProduct extends Model
{
    use HasFactory;
    protected $table = "comment_product";
    protected $fillable = [
        'id_product', 'id_user', 'name_user', 'avatar_user', 'comment', 'id_comment'
    ];

}