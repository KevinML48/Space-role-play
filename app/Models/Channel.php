<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    // Relation inverse avec Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation avec Message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
