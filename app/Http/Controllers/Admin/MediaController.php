<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Input, Request, View, Validator, Redirect, Sentinel, Response, Image, DB;
use App\Models\Media;
use Illuminate\Http\Request AS httpRequest;

class MediaController extends BaseController {

	public function __construct()
    {

        $this->model = new Media;

    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(httpRequest $request)
	{
		if(Input::has('action'))
		{
			if(Input::get('action') == 'delete'){
				$id = Input::get('id');
				$file = Media::find($id);
				if($file)
				{
					if(file_exists(public_path($file->file_path))){
	                    @unlink(public_path($file->file_path));
	                }
	                if($file->media_type == 'Image'){
		                if($file->thumb_file_path && file_exists(public_path($file->thumb_file_path))){
		                    @unlink(public_path($file->thumb_file_path));
		                }
		                if($file->slider_file_path && file_exists(public_path($file->slider_file_path))){
		                    @unlink(public_path($file->slider_file_path));
		                }
		            }
		            $file->forcedelete();
		        }
			}
			if(Input::get('action') == 'bulk_delete')
			{
				$ids = Input::get('ids');
				foreach ($ids as $key => $id) {
					$file = Media::find($id);
					if($file)
					{
						if(file_exists(public_path($file->file_path))){
		                    @unlink(public_path($file->file_path));
		                }
		                if($file->media_type == 'Image'){
			                if($file->thumb_file_path && file_exists(public_path($file->thumb_file_path))){
			                    @unlink(public_path($file->thumb_file_path));
			                }
			                if($file->slider_file_path && file_exists(public_path($file->slider_file_path))){
			                    @unlink(public_path($file->slider_file_path));
			                }
			            }
			            $file->forcedelete();
					}
				}
			}
		}
		$result = Media::orderBy('created_at', 'desc');
		$req = isset($_GET['req'])?$_GET['req']:null;
		$page = isset($_GET['page'])?$_GET['page']:1;
		if(Input::has('req'))
		{
			$req = Input::get('req');
			$result->where('file_name', 'like', '%' . Input::get('req') . '%');
		}
		$files = $result->Paginate(18);
		if ($request->ajax()) {
			return view('admin.media.ajax_index', array('files'=>$files, 'req'=>$req, 'page'=>$page));
		}
		else{
			return view('admin.media.index', array('files'=>$files, 'req'=>$req, 'page'=>$page));
		}
	}

	public function ajaxIndex()
	{
		return view('admin.media.ajax_index');
	}

	public function popup(httpRequest $request, $popup_type="photos", $type=null, $holder_attr="", $related_id=null)
	{
		if($type && $type != 'all')
		{
			if($type == 'Products')
			{
				$result = Media::where('related_id', $related_id)->where('related_type', $type)->orderBy('created_at', 'DESC');
			}
			else{
				$typeArr =  explode('-', $type);
				$result = Media::whereIn('media_type', $typeArr)->whereNull('related_type')->orderBy('created_at', 'DESC');
			}
		}
		else
			$result = Media::orderBy('created_at', 'DESC');

		$req = isset($_GET['req'])?$_GET['req']:null;
		$page = isset($_GET['page'])?$_GET['page']:1;
		if(Input::has('req'))
		{
			$req = Input::get('req');
			$result->where('file_name', 'like', '%' . Input::get('req') . '%');
		}

		$files = $result->Paginate(12);
		
		$popTypeArr = explode('-', $popup_type);
		$popup_type = $popTypeArr[0];
		$id = isset($popTypeArr[1])?$popTypeArr[1]:null;

		if (isset($_GET['req']) || isset($_GET['page'])) {
			return view('admin.media.ajax_index_popup', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'popup_type'=>$popup_type, 'id'=>$id, 'holder_attr'=>$holder_attr, 'related_id'=>$related_id, 'type'=>$type));
		}
		else{
			return view('admin.media.popup', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'popup_type'=>$popup_type, 'id'=>$id, 'holder_attr'=>$holder_attr, 'related_id'=>$related_id, 'type'=>$type));
		}
	}

	public function save(Request $request)
	{
		$files = Input::file('files');
		$data = Input::all();
		$json = array(
        	'files' => array()
        );
	    foreach ($files as $key=> $file) {
		    $filename = $file->getClientOriginalName().".".$file->getClientOriginalExtension();

		    $upload = $this->uploadFile($file, $this->model->uploadPath['media']);
		    if($upload['success']) {

		    	$media = $this->model;
		    	$media->file_name = $upload['filename'];
		    	$media->file_path = $upload['filepath'];
		    	if(isset($data['related_type']) && $data['related_type']!='' && isset($data['related_id']) && $data['related_id']!='')
		    	{
		    		$media->related_type = $data['related_type'];
		    		$media->related_id = $data['related_id'];
		    	}

		    	if($upload['mediatype'] == 'Image')
		    	{
		    		$orgDestPath = public_path($this->model->uploadPath['media']);
		    		$thumbDestPath = public_path($this->model->uploadPath['media_thumb']);
		    		Image::make($orgDestPath.$upload['filename'])->fit(200)->save($thumbDestPath.$upload['filename']);
		    		$media->thumb_file_path = $this->model->uploadPath['media_thumb'].$upload['filename'];
		    	}
		    	else
		    		$media->thumb_file_path = $upload['mediathumb'];
		    	$media->file_type = $upload['filetype'];
		    	$media->file_size = $upload['filesize'];
		    	$media->dimensions = $upload['filedimensions'];
		    	$media->media_type = $upload['mediatype'];
		    	$media->save();
		    	
			    $json['files'][] = array(
			            'name' => $filename,
			            'size' => $upload['filesize'],
			            'url' => \URL::to('').'/public/'.$media->thumb_file_path,
			            'id' => $media->id,
			            'original_file' => \URL::to('').'/public/'.$media->file_path,
			            'type' => $media->file_type,
			    );
			}
	    }
	    return response()->json($json);
	}

	public function storeExtra($id)
	{
		if($media = Media::find($id))
		{
			$media->title = Input::get('title');
			$media->description = Input::get('description');
			$media->alt_text = Input::get('alt_text');
			$media->save();
			return response()->json(array('message'=>'Media details successfully updated!'));
		}
		return response()->json(array('message'=>'Media not found!'));
	}

	public function edit($id)
	{
		if($file = Media::find($id))
		{
			return view('admin.media.edit', array('file'=>$file));
		}
	}

	public function logo_popup()
	{
		
		$files = Logos::orderBy('created_at', 'DESC')->get();
		return view('admin.media.logo_popup', array('files'=>$files));
	}

}
