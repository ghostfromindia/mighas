<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use App\Models\Support, Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image;
use Illuminate\Http\Request as Reqst;

class SupportController extends BaseController
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

        $this->model = new Support;

        $this->route .= '.support';
        $this->views .= '.support';
        $this->url = "admin/support/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'email', 'subject', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->addColumn('action_view', function($obj) use($route){
                return '<a href="' . route($route.'.view', [encrypt($obj->id)]).'" class="btn btn-success btn-sm"><i class="fa fa-search" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['action_delete', 'action_view']);
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Support request successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
