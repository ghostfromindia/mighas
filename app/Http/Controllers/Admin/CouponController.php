<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request as HttpRequest;

use App\Models\Coupon;
use View,Redirect, DB, Input;

class CouponController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Coupon;
        $this->route .= '.coupons';
        $this->views .= '.coupons';
        $this->url = "admin/coupons/";

        $this->resourceConstruct();

    }
    protected function getCollection() {
        return $this->model->select('id', 'coupon_code', 'minimum_purchase_value', 'discount_type', 'discount_percentage', 'discount_amount', 'maximum_discount_value', 'start_date', 'end_date', 'status');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('discount_type', function($obj){
                if($obj->discount_type == 'Percentage')
                    return $obj->discount_percentage.' %';
                else
                    return $obj->discount_amount;
            })
            ->editColumn('start_date', function($obj){
                return date('d M, Y', strtotime($obj->start_date));
            })
            ->editColumn('end_date', function($obj){
                return date('d M, Y', strtotime($obj->end_date));
            })
            ->editColumn('status', function($obj) use($route) { 
                if($obj->status == 1)
                {
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]).'" class="btn btn-success btn-sm miniweb-btn-warning-popup" data-message="Are you sure, want to disable this page?"><i class="fa fa-check-circle"></i></a>'; 
                }
                else{
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]) . '" class="btn btn-danger btn-sm miniweb-btn-warning-popup" data-message="Are you sure, want to enable this page?"><i class="fa fa-times-circle"></i></a>';
                }
            })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    public function store()
    {
        $this->model->validate();
        $data = $this->prepareData();
        $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        $this->model->fill($data);
        $this->model->save();
        return $this->redirect('created', 'success', 'edit', [encrypt($this->model->id)]);
    }

    public function update() {
        $data = Input::all();
        $id = decrypt($data['id']);
        $this->model->validate(Input::all(), $id);
        if($obj = $this->model->find($id)){
            $data = $this->prepareData();
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
            $obj->update($data);
            return $this->redirect('updated','success', 'edit', [encrypt($obj->id)]);
        } else {
            return $this->redirect('notfound');
        }
    }

}
