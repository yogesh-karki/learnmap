<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view('map.index',compact('projects'));
    }
}
