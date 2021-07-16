<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUserRequest extends Model
{
    use HasFactory;

    protected $table = "project_user_request";

    public $timestamps = false;
}
