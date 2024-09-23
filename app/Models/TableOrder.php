<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrder extends Model
{
    use HasFactory;

    public const BOOKED = '0';
    public const OVERTIME = '1';
    public const CANCEL = '2';
    public const DISHES_ARE_ON = '3';

    protected $table = 'table_order';
    protected $fillable = [
        'customer_id',
        'status',
        'order_date',
        'table_id',
    ];

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function customer(){
        return $this->belongsTo(Customers::class);
    }
}