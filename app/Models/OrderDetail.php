<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    public const STATUS_PENDING = '0';
    public const STATUS_COOKING = '1';
    public const STATUS_DONE = '2';

    public const ACCEPTED = '1';
    public const ACCEPTED_NOT = '0';

    protected $table = 'order_detail';

    protected $fillable = [
      'order_id',
      'staff_id',
      'dish_id',
      'accept',
      'priority',
      'price',
      'quantity',
      'note',
      'status'
  ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}