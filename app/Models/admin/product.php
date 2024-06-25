<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $timestamp = true;
    protected $fillable = ['id_user', 'name', 'price', 'id_category', 'id_brand', 'status', 'sale', 'company', 'image', 'detail', 'description'];
    
    public function commentProduct(){
        return $this->hasMany('App\Models\admin\commentProduct', 'id_product');
    }

    public function brand()
    {
        return $this->hasOne('App\Models\admin\brand', 'id', 'id_brand');
    }
    public function category(){
        return $this->hasOne('App\Models\admin\category', 'id', 'id_category');
    }
}