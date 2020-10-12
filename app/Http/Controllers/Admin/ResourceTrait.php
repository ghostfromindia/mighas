<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use View, Input, Request, DataTables, Form, Redirect;
use Illuminate\Http\Exception\HttpResponseException;

trait ResourceTrait {

	protected $model, $entity;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function resourceConstruct()
	{
		$this->entity = $this->getEntityName();

		View::share(['route' => $this->route, 'views' => $this->views, 'entity' => $this->entity]);
	}

	protected function getEntityName() {
		$name = class_basename($this->model);
        $parts = preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY);
        return ucfirst(strtolower(implode(' ', $parts)));
	}

	/**
	 * Show the data list.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()) {
            $collection = $this->getCollection();
            $search = request()->get('data');
            if($search)
            {
                foreach ($search as $key => $value) {
                    $condition = null;
                    $keyArr =  explode('-', $key);
                    if(isset($keyArr[1]))
                    {
                        $key = $keyArr[1];
                        $condition = $keyArr[0];
                    }

                    if($value)
                    {
                        if($condition == 'date_between')
                        {
                            $date_array = explode('-', $value);
                            $from_date = $this->formatDate($date_array[0]);
                            $from_date = date('Y-m-d H:i:s', strtotime($from_date.' 00:00:00'));
                            $to_date = $this->formatDate($date_array[1]);
                            $to_date = date('Y-m-d H:i:s', strtotime($to_date.' 00:00:00'));
                            $collection->whereBetween($key, [$from_date, $to_date]);
                        }
                        else
                            $collection->where($key,$value);
                    }
                }
            }
            return $this->setDTData($collection)->make(true);
        } else {
			return view($this->views . '.index');
        }
	}

    public function formatDate($date) {
        $arr = explode("/",$date);

        $year  = trim($arr[2]);
        $month = trim($arr[1]);
        $day   = trim($arr[0]);

        return $year."-".$month."-".$day;
    }

	abstract protected function getCollection();

	protected function initDTData($collection, $queries = []) {
		$route = $this->route;
        $url = $this->url;
		return Datatables::of($collection)
            ->setRowId('row-{{ $id }}')
            ->addColumn('action_edit', function($obj) use ($route, $queries) { 
                return '<a href="' . route( $route . '.edit',  [encrypt($obj->id)] + $queries ) . '" style="padding: 0px;" title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : ''). '" ><img width="20px" src="'.url('public/edit.png').'" alt="edit"></a>';
            })
            ->addColumn('action_delete', function($obj) use ($route, $queries) { 
                return '<a href="' . route( $route . '.destroy',  [encrypt($obj->id)] + $queries ) . '" class="btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : '') . '" style="padding: 0px;"><img width="20px" src="'.url('public/delete.png').'" alt="edit"></a>';
            });
	}

	protected function setDTData($collection) {
		return $this->initDTData($collection);
	}

	/**
	 * Show the add form.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view($this->views . '.form')->with('obj', $this->model);
	}

	public function show($id)
	{
		return $this->edit($id);
	}

    public function store()
    {
    	$this->model->validate();
        return $this->_store();
    }

	protected function _store()
	{
		$this->model->fill($this->prepareData());
		$this->model->save();
		return $this->redirect('created', 'success', 'edit', [encrypt($this->model->id)]);
	}

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            return view($this->views . '.form')->with('obj', $obj);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function update() {
        $data = Input::all();
        $id = decrypt($data['id']);
    	$this->model->validate(Input::all(), $id);
        return $this->_update($id);
    }

    protected function _update($id) {
        if($obj = $this->model->find($id)){
        	$obj->update($this->prepareData());
            return $this->redirect('updated','success', 'edit', [encrypt($obj->id)]);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function changeStatus($id, $status=null)
    {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            if($status)
                $set_status = ($status == 1)?0:1;
            else
            {
                $set_status = ($obj->status == 1)?0:1;
                $status = $obj->status;
            }
            $obj->status = $set_status;
            $obj->save();
            $message = ($status == 1)?"disabled":"enabled";
            return Redirect::route($this->route . '.index', ['parent'=>$obj->parent_id])->withSuccess($this->entity.' successfully '.$message.'!');
        }
        return $this->redirect('notfound');
    }
    
    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return $this->redirect('removed', 'success', 'index');
        }
        
        return $this->redirect('notfound');
    }

    public function bulkEnable()
    {
        $data = Input::all();
        if($data['ids'])
        {
            foreach ($data['ids'] as $key => $value) {
                $id = (int)str_replace('row-', '', $value);
                $obj = $this->model->find($id);
                if ($obj) {
                    $obj->status = 1;
                    $obj->save();
                }
            }
            \Session::flash('success','Selected items successfully enabled!');
        }
        exit;
    }

    public function bulkDisable()
    {
        $data = Input::all();
        if($data['ids'])
        {
            foreach ($data['ids'] as $key => $value) {
                $id = (int)str_replace('row-', '', $value);
                $obj = $this->model->find($id);
                if ($obj) {
                    $obj->status = 0;
                    $obj->save();
                }
            }
            \Session::flash('success','Selected items successfully disabled!');
        }
        exit;
    }

    public function bulkDelete()
    {
        $data = Input::all();
        if($data['ids'])
        {
            foreach ($data['ids'] as $key => $value) {
                $id = (int)str_replace('row-', '', $value);
                $obj = $this->model->find($id);
                if ($obj) {
                    $obj->delete();
                }
            }
            \Session::flash('success','Selected items successfully deleted!');
        }
        exit;
    }

    public function checkCodeExist()
    {
        /* RECEIVED VALUE */
         $id = $_REQUEST['id'];
         $code = $_REQUEST['code'];
         
         $where = "code='".$code."'";
         if($id)
            $where .= " AND id != ".$id;
         $resuts = $this->model->whereRaw($where)->get();
         
         if (count($resuts)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }

    /**
     * Redirect after an operation
     * @return Redirect redirect object
     */
	protected function redirect($op = null, $type = 'success', $view = 'edit', $params='')
	{
        if($type == 'success')
        {
            $message = '';
            
            if($op =='created')
                $message = 'created';
            elseif($op =='removed')
                $message = 'deleted';
            elseif($op =='disabled')
                $message = 'disabled';
            elseif($op =='enabled')
                $message = 'enabled';
            elseif($op == 'updated')
                $message = 'updated';

            if (Request::ajax())
                $response = response()->json(['success'=>$this->entity.' successfully '.$message.'!']);
            else
                $response = Redirect::route($this->route . '.' . $view, $params)->withSuccess($this->entity.' successfully '.$message.'!');
        }
        else
            if (Request::ajax())
                $response = response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
            else
                $response = Redirect::back()->withInput();

        return $response;
	}
    
    /**
     * Prepare input data before saving in to DB
     * @param  boolean $update object id if the operation is update, otherwise false
     * @return array   Prepared field=>value array
     */
    protected function prepareData($update = false) {
    	return Input::all();
    }

    protected function select2($searchfor,$key,$label){
        $data = $this->model->where($searchfor, 'like', '%'.$key.'%')->get();
        $json = [];
        foreach($data as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->{$label}];
        }
        return json_encode($json);
    }

    protected function create_slug($slug){
        $text = preg_replace('~[^\pL\d]+~u', '-', $slug);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }


}