<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}