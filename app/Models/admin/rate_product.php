<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rate_product extends Model
{
    use HasFactory;
    protected $table = 'rate_product';
    public $timestamp = true;
    protected $fillable = ['id_user', 'id_product', 'rate'];
}