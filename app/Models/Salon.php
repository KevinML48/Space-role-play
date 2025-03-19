<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id']; // Assure-toi que tes colonnes sont ici

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}
}
