<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryDish extends Model
{
    protected $table = 'category_dish';

    protected $fillable = ['category_id, dish_id'];

    public $timestamps = false;

    public function category()
    : HasOne {
        return $this->hasOne(Categories::class);
    }

    public function dish()
    : HasOne {
        return $this->hasOne(Dish::class, 'id', 'dish_id');
    }
}