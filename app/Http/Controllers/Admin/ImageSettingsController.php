<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\ResourceTrait;
use Input, Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\ImageSettings;
use App\Models\Media;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Reqst;

class ImageSettingsController extends BaseController
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

        $this->model = new ImageSettings;

        $this->route .= '.image-settings';
        $this->views .= '.image_settings';
        $this->url = "admin/image-settings/";

        $this->resourceConstruct();

    }

    protected function getCollection() {
        $collection = DB::table('media_settings')->select('media_settings.id', 'media_settings.width' ,'media_settings.height', 'media_types.type', 'media_settings.updated_at')->join('media_types', 'media_settings.type_id', '=', 'media_types.id')->whereNull('media_settings.deleted_at');

        return $collection; 
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_delete']);
    }


    public function store(Reqst $r)
    {
        $data = $r->all();

        $validator = Validator::make($data, [
            'type.*' => 'required|max:250',
            'width.*' => 'required|numeric|digits_between:1,5',
            'height.*' => 'required|numeric|digits_between:1,5',
        ]);

        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        else
        {
            foreach ($data['type'] as $key => $type) {
                $input['type_id'] = $type;
                $input['width'] = $data['width'][$key];
                $input['height'] = $data['height'][$key];
                $setting = new ImageSettings;
                $setting->fill($input);
                $setting->save();
            }

            return Redirect::to(url('admin/image-settings'))->withSuccess('Image Settings successfully saved!'); 
        } 
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->delete();
            return response()->json(['success'=>'Setting successfully deleted']);
        }
        return response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
    }

}
