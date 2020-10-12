<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\District;
use App\Models\BranchLandmark;
use DB, Image, Route;
use App\Models\FrontendPage;

class BranchController extends Controller
{
    
    public function index(Request $request)
    {
    	$data = $request->all();
    	$branches = Branch::where('status', 1);
    	$selected_location = null;
    	$selected_district = null;
    	$locations = null;
    	if($data)
    	{
    		if(isset($data['location']) && $data['location'] != '')
    		{
    			$selected_location = $data['state'];
    			$branches->where('state_id', $selected_location);
    		}
    		if(isset($data['district']) && $data['district'] != '')
    		{
    			$selected_district = $data['district'];
                $branches->where('district_id', $selected_district);
    		}
    	}
    	 $branches = $branches->limit(8)->get();

    	$branch_marker = [];
    	foreach ($branches as $key => $branch) {
    		if($branch->lattitude && $branch->longitude)
    		{
	    		$branch_marker[$key]['title'] = $branch->page_heading;
	    		$branch_marker[$key]['lat'] = $branch->lattitude;
	    		$branch_marker[$key]['lng'] = $branch->longitude;
	    		$address = nl2br($branch->address);
	    		$html = $branch->page_heading;
	    		$html .= '<br/>';
	    		if($branch->media)
	    		{
	    			$html .= '<img src="'.asset($branch->media->thumb_file_path).'">';
	    			$html .= "<br/>";
	    		}
	    		$html .= $address;
	    		$html .= '<br/>';
	    		if($branch->landline_number || $branch->mobile_number)
	    		{
	    			$html .= '<br/>Contact No : ';
	    			$contact_nums = [];
	    			if($branch->landline_number)
	    				$contact_nums[] = $branch->landline_number;
	    			if($branch->mobile_number)
	    				$contact_nums[] = $branch->mobile_number;
	    			$html .= implode(', ', $contact_nums);
	    		}
	    		if($branch->contact_person)
	    		{
	    			$html .= '<br/>Contact Person : '.$branch->contact_person;
	    			if($branch->contact_person_number)
	    				$html .= ", ".$branch->contact_person_number;
	    		}
	    		$url_address = urlencode($branch->branch_name.', '.$branch->address);
	    		$html .="<br><a target=_blank href=https://www.google.co.in/maps/search/".$url_address."/@'+ '".$branch->lattitude."' +','+ '".$branch->longitude."' +',15z>Locate</a>";

	    		$branch_marker[$key]['description'] = $html;
	    	}
    	}
    	$response = json_encode($branch_marker);
        $states = DB::table('states')->select('states.id', 'states.name')
            ->join('branches', 'branches.state_id', '=', 'states.id')
            ->where('branches.status', 1)
            ->whereNull('branches.deleted_at')
            ->groupBy('states.id')->get();

    	$districts = DB::table('districts')->select('districts.id', 'districts.name')
            ->join('branch_landmarks', 'districts.id', '=', 'branch_landmarks.district_id')
            ->join('branches', 'branches.landmark_id', '=', 'branch_landmarks.id')
            ->where('branches.status', 1)
            ->whereNull('branches.deleted_at')
            ->groupBy('districts.id')->get();


    	$name = Route::currentRouteName();
        $meta_details = FrontendPage::where('slug',$name)->first();
        return view('hykon/pages/outlet', ['branches'=>$branches,'states' =>$states,'branches_json'=>$response, 'districts'=>$districts, 'selected_location'=>$selected_location, 'selected_district'=>$selected_district, 'locations'=>$locations, 'meta_details'=>$meta_details]);
    }

    public function view($branch)
    {
    	$obj = Branch::where('status', 1)->where('slug', $branch)->first();
    	if($obj)
    	{
    		$branch_marker = [];
    		if($obj->lattitude && $obj->longitude)
    		{
	    		$branch_marker['title'] = $obj->page_heading;
	    		$branch_marker['lat'] = $obj->lattitude;
	    		$branch_marker['lng'] = $obj->longitude;
	    		$address = nl2br($obj->address);
	    		$html = $obj->page_heading;
	    		$html .= '<br/>';
	    		if($obj->media)
	    		{
	    			$html .= '<img src="'.asset($obj->media->thumb_file_path).'">';
	    			$html .= "<br/>";
	    		}
	    		$html .= $address;
	    		$html .= '<br/>';
	    		if($obj->landline_number || $obj->mobile_number)
	    		{
	    			$html .= '<br/>Contact No : ';
	    			$contact_nums = [];
	    			if($obj->landline_number)
	    				$contact_nums[] = $obj->landline_number;
	    			if($obj->mobile_number)
	    				$contact_nums[] = $obj->mobile_number;
	    			$html .= implode(', ', $contact_nums);
	    		}
	    		if($obj->contact_person)
	    		{
	    			$html .= '<br/>Contact Person : '.$obj->contact_person;
	    			if($obj->contact_person_number)
	    				$html .= ", ".$obj->contact_person_number;
	    		}
	    		$url_address = urlencode($obj->branch_name.', '.$obj->address);
	    		$html .="<br><a target=_blank href=https://www.google.co.in/maps/search/".$url_address."/@'+ '".$obj->lattitude."' +','+ '".$obj->longitude."' +',15z>Locate</a>";

	    		$branch_marker['description'] = $html;
	    	}
	    	$response = json_encode($branch_marker);
    		return view('hykon/pages/outlet_details', ['obj'=>$obj, 'branches_json'=>$response]);
    	}
    	else
    		abort('404');
    }
    
    public function ajax_branch_locations($district_id)
    {
        $locations = DB::table('branch_landmarks')->select('branch_landmarks.id', 'branch_landmarks.landmark')->join('branches', 'branches.landmark_id', '=', 'branch_landmarks.id')->where('branches.status', 1)->whereNull('branches.deleted_at')->where('branch_landmarks.district_id', $district_id)->orderBy('landmark')->groupBy('branch_landmarks.id')->get();
        
        $json = [];
        foreach($locations as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->landmark];
        }
        return \Response::json($json);
    }
}
