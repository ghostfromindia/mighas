<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\Settings;
use App\Models\Media;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

class SettingsController extends BaseController
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

        $this->model = new Settings;

        $this->route .= '.settings';
        $this->views .= '.settings';
        $this->url = "admin/settings/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        $collection = DB::table('settings')->select('settings.id', 'settings.code' ,'settings.type', 'settings.value', 'media_library.file_path', 'settings.updated_at')->leftJoin('media_library', 'media_library.id', '=', 'settings.media_id')->whereNull('settings.deleted_at');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('value', function($obj) {
                if($obj->type == 'Image')
                    return '<a href="javascript:void(0);" data-src="'.URL::asset('/').$obj->file_path.'" data-title="'.$obj->code.'" class="view-image">'.$obj->value.'</a>';
                else
                    return $obj->value; 
            })
            ->addColumn('action_ajax_edit', function($obj) use ($route) { 
                return '<a href="' . route( $route . '.edit',  [encrypt($obj->id)]  ) . '" class="btn btn-info btn-sm open-ajax-confirm" title="'.$obj->code.'" ><i class="fa fa-edit"></i></a>'; 
            })
            ->rawColumns(['value', 'action_ajax_edit']);
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            return view($this->views . '.edit')->with('obj', $obj);
        } else {
            return $this->redirect('notfound');
        }
    }


    public function store(Reqst $r)
    {
        $data = $r->all();
;

        $validator = Validator::make($data, [
            'key.*' => 'required|max:250',
            'value.*' => 'nullable',
            'image.*' => 'nullable|image',
        ]);

        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            foreach ($data['type'] as $key => $type) {
                $input['type'] = $type;
                $input['code'] = $data['code'][$key];
                if($type == 'Image')
                {
                    $upload = $this->uploadFile($data['image'][$key], $this->model->uploadPath['settings']);
                    if($upload['success']) {
                        $media = new Media;
                        $result = $this->saveMedia($upload);
                        $input['value'] = $result['name'];
                        $input['media_id'] = $result['id'];
                    }
                    else
                        return Redirect::back()->withError('Oops, something wrong happend Please try again.');
                }
                else
                    $input['value'] = $data['value'][$key];
                $setting = new Settings;
                $setting->fill($input);
                $setting->save();
            }

            return Redirect::to(url('admin/settings'))->withSuccess('Settings successfully saved!'); 
        } 
    }

    public function update(Reqst $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $validator = Validator::make($data, [
            'value' => 'nullable|max:250',
            'image' => 'nullable|image',
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>'Oops!! look like you have missed some important data, please check.']);
        }
        else
        {
            if($obj = $this->model->find($id)){
                if($data['type'] == 'Image')
                {
                    $upload = $this->uploadFile($data['image'], $this->model->uploadPath['settings'], ['Thumbnails']);
                    if($upload['success']) {
                        $media = new Media;
                        $result = $this->saveMedia($upload);
                        $obj->value = $result['name'];
                        $obj->media_id = $result['id'];
                    }
                    else
                        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
                }
                else
                    $obj->value = $data['value'];

                $obj->save();

                return response()->json(['success'=>'Setting successfully updated']);
            } else {
                return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
            }
        }
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'User successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

    public function changeStatus($id)
    {
        //$id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            if($obj->banned_at)
            {
                $obj->banned_at = null;
                $message = 'enabled';
            }
            else
            {
                $obj->banned_at = date('Y-m-d H:i:s');
                $message = 'disabled';
            }
            $obj->save();
            return response()->json(['success'=>'User successfully '.$message]);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
