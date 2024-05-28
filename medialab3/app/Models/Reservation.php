<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'start_date',
        'end_date',
        'reason',
        'Defect',
        'status'
    ];
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
