<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
   protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['product_id','category_id'];
    
     public function category() {
        return $this->hasOne('App\Category','category_id','id');
    }
}
