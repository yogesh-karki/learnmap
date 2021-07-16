<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterResponse(Request $request){
        $provinceID  = (int)$request->selectedProvince; //3
        $districtID  = (int)$request->selectedDistrict; //31
        $projectID = (int)$request->selectedProject; //
        // $provinceID  = 3; //3
        // $districtID  = 31; //31
        // $projectID = $request->filterProject; //
        $responses = Response::with(['userRequest','institution','individual','inventories'])->get();

        $features = $responses->when($districtID,function($query) use ($districtID){
                return $query->filter(function($item) use ($districtID){
                    return optional($item->individual)->district_id==$districtID || optional($item->institution)->district_id==$districtID;
                });
            })
            ->when($provinceID,function($query) use ($provinceID){
                return $query->filter(function($item) use ($provinceID){
                    return optional($item->individual)->province_id==$provinceID || optional($item->institution)->province_id==$provinceID;
                });
            })
            ->when($projectID,function($query) use ($projectID){
                return $query->where('project.id',$projectID);
            })->values();
        $response['type'] = 'FeatureCollection';
        $i = 0;
        foreach($features as $item){
            $response['features'][$i]['type']='Feature';
            $response['features'][$i]['properties']=$item;
            $response['features'][$i]['geometry']['type']="Point";
            $response['features'][$i]['geometry']['coordinates']=$item->institution_id ? json_decode($item->institution->coordinates) : json_decode($item->individual->coordinates);
            $i++;
        }
        if(count($features)==0){
            $response['features'] = [];
        }
        return $response;

    }
}
