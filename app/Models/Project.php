<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function inventories(){
        return $this->hasMany(Inventory::class,'project_id');
    }
    public function responses(){
        return $this->belongsToMany(Response::class);
    }
    public function user_requests(){
        return $this->belongsToMany(UserRequest::class);
    }

}
