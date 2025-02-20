<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function budgetPlans()
    {
        return $this->hasMany(BudgetPlan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
} 