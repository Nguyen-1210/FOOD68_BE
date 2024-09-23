<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected $fillable = [
        'name',
        'floor_id',
        'active'
    ];

    public function floor()
    : BelongsTo{
        return $this->belongsTo(Floor::class);
    }

    public function table_order()
    : HasMany{
        return $this->hasMany(TableOrder::class);
    }

}