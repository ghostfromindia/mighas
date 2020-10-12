<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request as HttpRequest;

use App\Models\SearchHistory;
use View,Redirect, DB, Input;
use App\Exports\SearchTermsExport;
use App\Imports\SearchTermImports;
use Maatwebsite\Excel\Facades\Excel;

class SearchHistoryController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new SearchHistory;
        $this->route .= '.search-history';
        $this->views .= '.search_history';
        $this->url = "admin/search-history/";

        $this->resourceConstruct();

    }
    protected function getCollection() {
        $collection = DB::table('search_history')->select('search_history.id', 'search_history.search_term', 'search_history.count', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"),
        'search_history.updated_at')->leftJoin('users', 'search_history.user_id', '=', 'users.id');
        return $collection;
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('updated_at', function($obj) { return date('m/d/Y H:i:s', strtotime($obj->updated_at)); })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->rawColumns(['action_delete']);
    }

    public function store(HttpRequest $request)
    {
        ini_set('max_execution_time', '0');
        $this->validate($request, [
          'excel_file'  => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('excel_file')->getRealPath();
        $rows = Excel::toArray(new SearchTermImports, $path, null, \Maatwebsite\Excel\Excel::XLSX)[0];
        foreach ($rows as $key => $value) {
            $searches = SearchHistory::where('search_term', $value['term'])->whereNull('user_id')->first();
            if($searches)
                $searches->count = $searches->count+1;
            else
            {
                $searches = new SearchHistory;
                $searches->search_term = $value['term'];
                $searches->count = 1;
            }
            $searches->save();
        }
        return redirect()->back()->withSuccess('Excel successfully imported!');
    }

    public function export()
    {
        return Excel::download(new SearchTermsExport, 'search_terms.xlsx');
    }

}
