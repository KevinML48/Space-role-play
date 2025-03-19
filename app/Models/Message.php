<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['salon_id', 'user_id', 'content'];

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

