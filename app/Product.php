<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id','name','description','price','image'];
    
     public function categories() {
        return $this->hasMany('App\ProductCategory','product_id','id');
    }
}
