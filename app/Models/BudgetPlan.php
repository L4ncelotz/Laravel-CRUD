<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
} 