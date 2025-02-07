<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /** @use HasFactory<\Database\Factories\PetFactory> */
    use HasFactory;
    protected $fillable = ['pet_id', 'name', 'species', 'breed'
    , 'age', 'price', 'status',
    'detail','image','created_at'];
}
