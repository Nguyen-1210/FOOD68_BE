<?php

namespace App\Models;

use App\Enums\DishStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishs';

    protected $casts = [
      'status' => DishStatus::class,
  ];
  
    protected $fillable = ['name', 'thumbnail', 'status', 'note', 'original_price'];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Categories::class, 'category_dishes', 'dish_id', 'category_id');
    }
}