<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    use HasFactory;

    protected $table = 'floors';


    protected $fillable = [
        'name',
        'ordering',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastOrdering = static::max('ordering') ?? 0;
            $model->ordering = $lastOrdering + 1;
        });
    }

      /**
     * @return hasMany
     */
    public function table(): HasMany{
      return $this->hasMany(Table::class);
  }
}