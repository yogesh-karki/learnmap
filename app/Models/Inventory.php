<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function responses(){
        return $this->belongsToMany(Response::class);
    }

    public function user_requests(){
        return $this->belongsToMany(UserRequest::class);
    }
}
