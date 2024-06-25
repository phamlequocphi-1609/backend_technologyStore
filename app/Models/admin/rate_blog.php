<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rate_blog extends Model
{
    use HasFactory;
    protected $table = 'rate_blog';
    public $timestamp = true;
    protected $fillable = ['id_user', 'id_blog', 'rate'];
}