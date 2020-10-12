<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request as HttpRequest;

use App\Models\FrontendPage;
use View,Redirect, DB;

class FrontendPageController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new FrontendPage;
        $this->route .= '.frontend-pages';
        $this->views .= '.frontend_pages';
        $this->url = "admin/frontend-pages/";

        $this->resourceConstruct();

    }
    protected function getCollection() {
        return $this->model->select('id', 'name', 'browser_title', 'meta_keywords');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit']);
    }

}
