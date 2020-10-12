<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request as HttpRequest;

use App\Models\Products\Review;
use View,Redirect, DB;

class ReviewController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Review;
        $this->route .= '.reviews';
        $this->views .= '.reviews';
        $this->url = "admin/reviews/";

        $this->resourceConstruct();

    }
    protected function getCollection() {
        $collection = DB::table('product_reviews')->select('product_reviews.id', 'product_reviews.title', 'product_reviews.rating', 'product_reviews.status', 'product_reviews.is_verified', 'product_variants.name', 'product_reviews.updated_at')->join('product_variants', 'product_variants.id', '=', 'product_reviews.products_id');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('status', function($obj) use ($route) {
                if($obj->status == 1)
                    return '<a href="' . route( $route . '.change-status',  [encrypt($obj->id), $obj->status] ) . '" class="btn btn-success btn-sm" ><i class="fa fa-times-circle"></i></a>';
                else
                    return '<a href="' . route( $route . '.change-status',  [encrypt($obj->id), $obj->status] ) . '" class="btn btn-danger btn-sm" ><i class="fa fa-check-circle"></i></a>';
            })
            ->editColumn('rating', function($obj) {
                return '<div class="ratings" data-rating="'.$obj->rating.'"></div>';
            })
            ->rawColumns(['action_edit', 'action_delete', 'status', 'is_verified', 'rating']);
    }

}
