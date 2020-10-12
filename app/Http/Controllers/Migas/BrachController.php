<?php

namespace App\Http\Controllers\Migas;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class BrachController extends Controller
{
    public function states(){
       return $branches = DB::table('branches as b')
            ->join('states as s','b.state_id','=','s.id')->select('s.id','s.name')->distinct('name')->get()->toJson();
    }

    public function district($state_id){
        $branches = DB::table('branches as b')
            ->join('states as s','b.state_id','=','s.id')
            ->join('districts as d','d.id','=','b.district_id')
            ->where('b.state_id',$state_id)
            ->select('d.id','d.name')->distinct('name')->get()->toJson();

        if(!empty(Input::get('id'))){
            return $branches = DB::table('districts as d')
                ->join('states as s','d.state_id','=','s.id')
                ->where('d.state_id',$state_id)
                ->select('d.id','d.name')->distinct('name')->get()->toJson();
        }

        return $branches;
    }

    public function branch($district_id){
        return $branches = DB::table('branches as b')
            ->join('states as s','b.state_id','=','s.id')
            ->join('districts as d','d.id','=','b.district_id')
            ->where('b.district_id',$district_id)
            ->select('s.id','b.branch_name as name')->distinct('name')->get()->toJson();
    }

    public function list(){
        $branches =  DB::table('branches as b')
            ->join('states as s','b.state_id','=','s.id')
            ->join('districts as d','d.id','=','b.district_id');
        if(!empty(Input::get('state')) && Input::get('state')!='null'){
            $branches->where('b.state_id',Input::get('state'));
        }
        if(!empty(Input::get('district')) && Input::get('district')!='null'){
            $branches->where('b.district_id',Input::get('district'));
        }
        if(!empty(Input::get('branch')) && Input::get('branch')!='null'){
            $branches->where('b.id',Input::get('branch'));
        }
        return $branches->select('b.slug','b.branch_name as name','b.address','b.mobile_number as mobile')->distinct('name')->limit(8)->get()->toJson();
    }
}
