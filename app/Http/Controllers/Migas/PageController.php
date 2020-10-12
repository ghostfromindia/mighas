<?php

namespace App\Http\Controllers\Migas;

use App\Http\Controllers\BaseController;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Category;
use App\Models\District;
use App\Models\Key;
use App\Models\Page;
use App\Models\Products;
use App\Models\Slider;
use App\Models\States;
use App\Models\Support;
use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class PageController extends BaseController
{
    //

    public function career(){
        $page = Page::where('slug','career')->where('type','page')->first();
        if(!$page){
            $page = new Page();
        }
        $career = Page::where('type','Career')->where('status', 1)->get();
        return view('hykon.pages.career',compact('page','career'));
    }

    public function career_save(Request $request){

            $request->validate([
                'cv' =>  'required|mimetypes:application/pdf'
            ]);


         $upload = $this->uploadFile($request->cv,'uploads/resume/');
         $cv =  $this->saveMedia($upload);


         $support = new Support();
         $support->type = 'career';
         $support->name = $request->name;
         $support->email = $request->email;
         $support->subject = $request->job;
         $support->career_file_id = $cv['id'];
         $support->save();

            $mails = explode(',',Key::get('admin-email'));
            Mail::to($mails)->send(new \App\Mail\CareerMail($support));
        session()->flash('success','Resume saved successfully');
       return redirect('company/career');
    }


    public function contact(){
        $page = Page::where('slug','contact-us')->first();
        $branches = Branch::where('type','branch')->get();
        return view('hykon.pages.contact',compact('page','branches'));
    }

    public function about(){
        $page = Page::where('slug','about-us')->first();
        return view('hykon.pages.about',compact('page'));
    }

    public function history(){
        $slider = Slider::where('code','history')->first();
        $pages = Page::where('type','History')->where('status',1)->orderby('event_date_time','DESC')->get();
        return view('hykon.pages.history',compact('slider','pages'));
    }


    public function leadership(){
        $slider = Slider::where('code','leadership')->first();
        $pages = Page::where('type','Page')->where('slug','leadership')->where('status',1)->first();
        // if(!$pages){abort(404);}
        $teams = Banner::where('code','team')->first();
        return view('hykon.pages.leadership',compact('slider','pages','teams'));
    }


    public function delivery_polices(){
        $page = Page::where('type','Page')->where('slug','delivery-polices')->where('status',1)->first();
        return view('hykon.pages.default',compact('page'));
    }

    public function buying_guide(){
        $page = Page::where('type','Page')->where('slug','buying-guide')->where('status',1)->first();
        return view('hykon.pages.default',compact('page'));
    }


    public function blog(){
        $sort = Input::get('sort');
        $blogs = Page::where('type','Blog')->where('status',1);
        switch ($sort){
            case 'latest': $blogs->orderby('created_at','DESC');
            case 'views': $blogs->orderby('views','DESC');
            default : $blogs->orderby('created_at','DESC');
        }
        $blogs = $blogs->get();

        return view('hykon.pages.blog',compact('blogs'));
    }

    public function blog_details($slug){
        $type = 'Blog';
        $blog = Page::where('type','Blog')->where('slug',$slug)->where('status',1)->first();
        $blog->views = ++$blog->views;
        $blog->save();

        $related = Page::where('type','Blog')->where('slug','!=',$slug)->where('status',1)->get();
        return view('hykon.pages.blog_details',compact('blog','related','type'));
    }

    public function news(){
        $type = 'News';
        $news = Page::where('type','News')->where('status',1)->get();
        $events = Page::where('type','Events')->where('status',1)->orderby('event_date_time','DESC')->get();
        return view('hykon.pages.news',compact('news','events','type'));
    }

    public function event(){
        $type = 'Events';
        $news = Page::where('type','News')->where('status',1)->get();
        $events = Page::where('type','Events')->where('status',1)->orderby('event_date_time','DESC')->get();
        return view('hykon.pages.news',compact('news','events','type'));
    }

    public function news_details($slug){
        $type = 'News';
        $blog = Page::where('type','News')->where('slug',$slug)->where('status',1)->first();
        $blog->views = ++$blog->views;
        $blog->save();
        $related = Page::where('type','News')->where('slug','!=',$slug)->where('status',1)->get();
        return view('hykon.pages.blog_details',compact('blog','related','type'));
    }

    public function event_details($slug){
        $type = 'Events';
        $event = Page::where('type','Events')->where('slug',$slug)->where('status',1)->first();
        $event->views = ++$event->views;
        $event->save();
        $past_events = Page::where('type','Events')->where('event_date_time','<',Carbon::now()->format('Y-m-dTh:i'))->where('status',1)->get();
        $upcoming_events = Page::where('type','Events')->where('event_date_time','>=',Carbon::now()->format('Y-m-dTh:i'))->where('status',1)->get();
        return view('hykon.pages.event_details',compact('event','type','past_events','upcoming_events'));
    }

    public function warranty(){
        $states = States::all();
        $district = District::all();
        $category = Category::all();
        $products = Products::all();
        $page = Page::where('slug','warranty')->where('type','page')->first();
        if(!$page){
            $page = new Page();
        }
        return view('hykon.pages.warranty',compact('states','district','category','products','page'));
    }

    public function warranty_save(Request $request){


        $address = new Address();
        $address->user_id = 123456789;
        $address->full_name = $request->name;
        $address->mobile_code = '91';
        $address->mobile_number = $request->phone;
        $address->address1 = $request->address_1;
        $address->address2 = $request->address_2.', '.$request->street_1;
        $address->landmark = $request->landmark;
        $address->city = $request->district;
        $address->state = $request->state;
        $address->pincode = $request->pincode;
        $address->save();


        if($request->same != 'on'){
            $address1 = new Address();
            $address1->user_id = 123456789;
            $address1->full_name = $request->name;
            $address1->mobile_code = '91';
            $address1->mobile_number = $request->phone;
            $address1->address1 = $request->address_1_1;
            $address1->address2 = $request->address_2_1.', '.$request->street_1_1;
            $address1->landmark = $request->landmark_1;
            $address1->city = $request->district_1;
            $address1->state = $request->state_1;
            $address1->pincode = $request->pincode_1;
            $address1->save();
        }else{
            $address1 = $address;
        }



        $warranty = new Warranty();
        $warranty->type = $request->type;
        $warranty->name = $request->name;
        $warranty->mail = $request->email;
        $warranty->phone = $request->phone;
        $warranty->installation_address_id = $address1->id;
        $warranty->billing_address_id = $address->id;
        $warranty->pro_type = $request->pro_type;
        $warranty->model = $request->model;
        $warranty->pro_model = $request->pro_model;
        $warranty->serial_number = $request->serial_number;
        $warranty->inst_date = $request->inst_date;
        $warranty->dealer = $request->dealer;
        $warranty->contact_person = $request->contact_person;
        $warranty->save();

        $mails = explode(',',Key::get('admin-email'));
        Mail::to($mails)->send(new \App\Mail\WarrantyMail($warranty));

        session()->flash('success','Message saved successfully');
        return redirect('company/warranty');
    }
}
