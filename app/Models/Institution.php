<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function localLevel()
    {
        return $this->belongsTo(LocalLevel::class);
    }
    public function institutionType(){
        return $this->belongsTo(InstitutionType::class);
    }
}
