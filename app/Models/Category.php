<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relation avec Channel (corrigée)
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
