<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'server_id'];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
