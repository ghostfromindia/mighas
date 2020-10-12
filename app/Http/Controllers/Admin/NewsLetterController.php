<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\NewsletterSubscription, Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Illuminate\Http\Request as Reqst;

class NewsLetterController extends BaseController
{
    use ResourceTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new NewsletterSubscription;

        $this->route .= '.newsletter';
        $this->views .= '.newsletter';
        $this->url = "admin/newsletter/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'email', 'unsubscribed', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('unsubscribed', function($obj) use($route) { 
                 if($obj->unsubscribed == 0)
                {
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]).'" class="btn btn-success btn-sm miniweb-btn-warning-popup" data-message="Are you sure, want to unsubscribe newsletter?"><i class="fa fa-check-circle"></i></a>'; 
                }
                else{
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]) . '" class="btn btn-danger btn-sm miniweb-btn-warning-popup" data-message="Are you sure, want to subscribe newsletter?"><i class="fa fa-times-circle"></i></a>';
                }
            })
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->rawColumns(['unsubscribed', 'action_delete']);
    }

    public function changeStatus($id)
    {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {

            $set_status = ($obj->unsubscribed == 1)?0:1;
            $status = $obj->unsubscribed;
            $obj->unsubscribed = $set_status;
            $obj->save();

            $message = ($status == 1)?"subscribed":"unsubscribed";

            return Redirect::to(url('admin/newsletter'))->withSuccess('Newsletter successfully '.$message);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Subscription successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
