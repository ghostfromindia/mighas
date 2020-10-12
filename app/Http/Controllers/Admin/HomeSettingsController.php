<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Request, View, Redirect, DB, Datatables, Sentinel, Mail, Validator, Image, URL;
use App\Models\HomePageSettings;
use App\Models\Media;
use App\Models\Brand;
use Illuminate\Http\Request as Reqst;

class HomeSettingsController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new HomePageSettings;

        $this->route = 'admin.home-settings';
        $this->views = 'admin.home_settings';
        $this->url = "admin/home-settings/";

    }

    public function index()
    {
        $website_features = $this->model->where('section', 'website-features')->first();
        $banner = $this->model->where('section', 'home-banner')->first();
        $featured_brands = $this->model->where('section', 'featured-brands')->first();
        $contact = $this->model->where('section', 'footer-contact')->first();
        $social_media = $this->model->where('section', 'social-media')->first();
        $footer = $this->model->where('section', 'footer')->first();

        if(!empty($website_features->content)){$website_features_data = json_decode($website_features->content);}else{$website_features_data = [];}

        if(!empty($banner->content)){$banner_data = json_decode($banner->content);}else{$banner_data = [];}
            if(!empty($featured_brands->content)){$featured_brands_data = json_decode($featured_brands->content);}else{$featured_brands_data = [];}
        if($featured_brands_data && $featured_brands_data->featured_brands)
        {
            $brand_ids = (array)$featured_brands_data->featured_brands;
            $featured_brands_data->featured_brands = Brand::whereIn('id', $brand_ids)->pluck('brand_name', 'id');
        }
        if(!empty($contact->content)){$contact_data = json_decode($contact->content);}else{$contact_data = [];}
            if(!empty($social_media->content)){$social_media_data = json_decode($social_media->content);}else{$social_media_data = [];}
                if(!empty($footer->content)){$footer_data = json_decode($footer->content);}else{$footer_data = [];}

        return view($this->views . '.index', array('website_features'=>$website_features, 'website_features_data'=>$website_features_data, 'banner'=>$banner, 'banner_data'=>$banner_data, 'featured_brands'=>$featured_brands, 'featured_brands_data'=>$featured_brands_data, 'contact'=>$contact, 'contact_data'=>$contact_data, 'social_media'=>$social_media, 'social_media_data'=>$social_media_data, 'footer'=>$footer, 'footer_data'=>$footer_data));
    }

    public function store(Reqst $request)
    {
        $data = $request->all();
        if($data['submit'] == "banner_save")
        {
            $banner_data = [];

            $banner_id = $data['banner_id'];
            $media = Media::find($banner_id);
            $orgDestPath = public_path('uploads/media/');
            $bannerDestPath = public_path('uploads/home_settings/');
            Image::make($orgDestPath.$media->file_name)->crop($data['dataWidth'], $data['dataHeight'], $data['dataX'], $data['dataY'])->save($bannerDestPath.$media->file_name);

            $mobile_banner_id = $data['mobile_banner_id'];
            $mobile_media = Media::find($mobile_banner_id);
            $orgDestPath = public_path('uploads/media/');
            $mobileBannerDestPath = public_path('uploads/home_settings/');
            Image::make($orgDestPath.$mobile_media->file_name)->crop($data['dataMWidth'], $data['dataMHeight'], $data['dataMX'], $data['dataMY'])->save($mobileBannerDestPath.$mobile_media->file_name);

            $banner_data['banner_id'] = $data['banner_id'];
            $banner_data['original_file'] = 'uploads/media/'.$media->file_name;
            $banner_data['file'] = 'uploads/home_settings/'.$media->file_name;
            $banner_data['dataWidth'] = $data['dataWidth'];
            $banner_data['dataHeight'] = $data['dataHeight'];
            $banner_data['dataX'] = $data['dataX'];
            $banner_data['dataY'] = $data['dataY'];
            $banner_data['crop_data'] = $data['crop_data'];

            $banner_data['mobile_banner_id'] = $data['mobile_banner_id'];
            $banner_data['mobile_original_file'] = 'uploads/media/'.$mobile_media->file_name;
            $banner_data['mobile_file'] = 'uploads/home_settings/'.$mobile_media->file_name;
            $banner_data['mobile_dataWidth'] = $data['dataMWidth'];
            $banner_data['mobile_dataHeight'] = $data['dataMHeight'];
            $banner_data['mobile_dataX'] = $data['dataMX'];
            $banner_data['mobile_dataY'] = $data['dataMY'];
            $banner_data['mobile_crop_data'] = $data['mobile_crop_data'];

            $banner_data['title'] = $data['title'];
            $banner_data['image_alt'] = $data['image_alt'];
            $banner_data['banner_content'] = $data['banner_content'];

            $banner = $this->model->find(decrypt($data['banner_setting_id']));
            $banner->content = json_encode($banner_data);
            $banner->save();
        }
        elseif ($data['submit'] == 'website_features_save') {
            $new_data = [];
            $new_data['title'] = $data['website_features_title'];
            $new_data['content1'] = $data['content1'];
            $new_data['content2'] = $data['content2'];
            $new_data['content3'] = $data['content3'];
            $new_data['content4'] = $data['content4'];
            $obj = $this->model->find(decrypt($data['website_features_id']));
            $obj->content = json_encode($new_data);
            $obj->save();
        }
        elseif ($data['submit'] == 'featured_brands_save') {
            $new_data = [];
            $new_data['title'] = $data['featured_brands_title'];
            $new_data['featured_brands'] = $data['featured_brands'];
            
            $obj = $this->model->find(decrypt($data['featured_brands_setting_id']));
            $obj->content = json_encode($new_data);
            $obj->save();
        }
        elseif ($data['submit'] == 'contact_save') {
            $new_data = [];
            $new_data['title'] = $data['contact_title'];
            $new_data['contact_details'] = $data['contact'];
            $new_data['googlemap_iframe'] = $data['googlemap_iframe'];
            
            $obj = $this->model->find(decrypt($data['contact_setting_id']));
            $obj->content = json_encode($new_data);
            $obj->save();
        }
        elseif ($data['submit'] == 'social_media_save') {
            $new_data = [];
            $new_data['title'] = $data['social_media_title'];
            $new_data['social_media'] = $data['social_media'];
            
            $obj = $this->model->find(decrypt($data['social_media_setting_id']));
            $obj->content = json_encode($new_data);
            $obj->save();
        }
        elseif ($data['submit'] == 'footer_save') {
            $footer_data = [];
            $footer_data['title'] = $data['footer_title'];
            $description = [];
            if(isset($data['footer_description'])){

                foreach ($data['footer_description'] as $key => $value1) {
                    $description[] = $value1;
                }
            }
            $footer_data['content'] = $description;
            
            $footer = $this->model->find(decrypt($data['footer_setting_id']));
            $footer->content = json_encode($footer_data);
            $footer->save();
        }
        return Redirect::to(url('admin/home-settings'))->withSuccess('Home settings successfully updated!');
    }

}
