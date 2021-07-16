<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryUserRequest extends Model
{
    use HasFactory;

    protected $table = "inventory_user_request";

    public $timestamps = false;
}
