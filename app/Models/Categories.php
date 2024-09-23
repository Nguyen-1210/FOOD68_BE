<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    
    protected $casts = [
      'type' => CategoryType::class,
  ];

  protected $fillable = [
      'name',
      'thumbnail',
      'active',
      'type',
  ];

  public function categoryDish(): BelongsToMany
  {
      return $this->belongsToMany(CategoryDish::class);
  }
}