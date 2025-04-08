<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'server_id'];

    // Relation avec le serveur
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    // Relation avec les salons (si vous gardez les deux)
    public function salons()
    {
        return $this->hasMany(Salon::class);
    }

    // Relation avec les channels
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
