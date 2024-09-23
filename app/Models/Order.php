<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'table_order_id',
        'note',
        'total_price'
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function tableOrder()
    {
        return $this->belongsTo(TableOrder::class);
    }
}