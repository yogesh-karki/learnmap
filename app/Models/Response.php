<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $appends = ['project'];
    public function inventories(){
        return $this->belongsToMany(Inventory::class)->withPivot('quantity','unit');
    }

    public function institution(){
        return $this->belongsTo(Institution::class)->with(['district','province','localLevel','institutionType']);
    }

    public function individual(){
        return $this->belongsTo(Individual::class)->with(['district','province','localLevel']);
    }

    public function userRequest(){
        return $this->belongsTo(UserRequest::class)->select(['id','project_id'])->with('project');
    }

    public function getProjectAttribute()
    {
        return $this->userRequest->project;
    }
    public function projects(){
        return $this->belongsToMany(Project::class);
    }

}
