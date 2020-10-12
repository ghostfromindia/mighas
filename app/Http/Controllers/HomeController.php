<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Products\Variants as ProductVariant;
use App\Models\Products\Variants\Images AS ImageVariants;
use DB, Image;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $search = $request->get('term');
      
        $categories = DB::table('categories')->select('slug AS id', 'category_name AS name', DB::raw("'stores' AS type"))->where('category_name', 'like', '%'.$search.'%')->where('status', '1')->whereNull('deleted_at');
        $result = DB::table('product_variants')->select('product_variants.slug AS id', 'product_variants.name', DB::raw("'product' AS type"))->join('products', 'products.id', '=', 'product_variants.products_id')->where('product_variants.name', 'like', '%'.$search.'%')->where('is_completed', 1)->where('is_active', '1')->whereNull('products.deleted_at')->union($categories)->orderByRaw("CASE WHEN name LIKE '".$search."%' THEN 1 WHEN name LIKE '%".$search."' THEN 3 ELSE 2 END, name ASC")->groupBy('id')->take(15)->get();
 
        return response()->json($result);
            
    }

    public function update_image()
    {
        ini_set('max_execution_time', '0');
        $images = DB::table('product_images_tb')->select('product_images_tb.id AS img_id', 'product_variants.id', 'product_images_tb.big_image_url')->join('product_variants', 'product_images_tb.product_code', '=', 'product_variants.code')->where('product_images_tb.is_main', 1)->get();
        foreach ($images as $key => $image) {
            $img_url = str_replace('~', 'https://pittappillilonline.com', $image->big_image_url);
            $destinationPath = public_path('uploads/products/');
            $pathinfo = explode('/',$img_url);
            $lastElement = strtolower(end($pathinfo));
            $extra = uniqid();
            $file_name =  str_replace(" ", '-', $lastElement);
            $destination = $destinationPath.$file_name;
            if($this->save_image( $img_url, $destination))
            {
                $success = $this->create_image('200', '200', public_path('uploads/products/200x200'), $file_name, asset('uploads/products/'.$file_name));

                if($success)
                {
                    $media = new Media;
                    $media->file_name = $file_name;
                    $media->file_path = 'uploads/products/' . $file_name;
                    $media->thumb_file_path = 'uploads/products/200x200/'.$file_name;
                    $media->file_type = mime_content_type($destination);
                    $media->file_size = filesize($destination);

                    $imagedetails = getimagesize($destination);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $media->dimensions = $width." X ".$height;
                    $media->media_type = 'Image';
                    $media->related_type = 'Products';
                    $media->related_id = $image->id;
                    $media->save();
                    $id = $media->id;
                    $product = ProductVariant::find($image->id);
                    $product->image_id = $id;
                    $product->save();
                }
            }
            //DB::table('product_images_tb')->where('id', $image->img_id)->update(['status'=>1]);
        }
    }

    public function update_brand_images()
    {
        $images = DB::table('brands_tb')->where('status', 0)->take(25)->get();
        foreach ($images as $key => $image) {
            $img_url = $this->str_replace_first('~', 'https://pittappillilonline.com', $image->image_url);
            $destinationPath = public_path('uploads/brands/');
            $pathinfo = explode('/',$img_url);
            $lastElement = end($pathinfo);
            $extra = uniqid();
            $file_name =  str_replace(" ", '-', $extra.'_'.$lastElement);
            $destination = $destinationPath.$file_name;
            if($this->save_image( $img_url, $destination))
            {
                $success = $this->create_image('200', '200', public_path('uploads/brands/200x200'), $file_name, asset('uploads/brands/'.$file_name));

                if($success)
                {
                    $media = new Media;
                    $media->file_name = $file_name;
                    $media->file_path = 'uploads/brands/' . $file_name;
                    $media->thumb_file_path = 'uploads/brands/200x200/'.$file_name;
                    $media->file_type = mime_content_type($destination);
                    $media->file_size = filesize($destination);

                    $imagedetails = getimagesize($destination);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $media->dimensions = $width." X ".$height;
                    $media->media_type = 'Image';
                    $media->related_type = 'Brands';
                    $media->related_id = $image->brand_id;
                    $media->save();
                    $id = $media->id;
                    DB::table('brands')->where('id', $image->brand_id)->update(['media_id'=>$id]);

                    DB::table('brands_tb')->where('brand_id', $image->brand_id)->update(['status'=>1]);
                }
            }
        }
    }

    public function update_main_category_images()
    {
        $images = DB::table('main_category_tb')->get();
        foreach ($images as $key => $image) {
            $img_url = $this->str_replace_first('~', 'https://pittappillilonline.com', $image->image_url);
            $destinationPath = public_path('uploads/category/primary/');
            $pathinfo = explode('/',$img_url);
            $lastElement = end($pathinfo);
            $extra = uniqid();
            $file_name =  str_replace(" ", '-', $extra.'_'.$lastElement);
            $destination = $destinationPath.$file_name;
            if($this->save_image( $img_url, $destination))
            {
                $success = $this->create_image('200', '200', public_path('uploads/category/200x200'), $file_name, asset('uploads/category/primary/'.$file_name));

                if($success)
                {
                    $media = new Media;
                    $media->file_name = $file_name;
                    $media->file_path = 'uploads/category/primary/' . $file_name;
                    $media->thumb_file_path = 'uploads/category/200x200/'.$file_name;
                    $media->file_type = mime_content_type($destination);
                    $media->file_size = filesize($destination);

                    $imagedetails = getimagesize($destination);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $media->dimensions = $width." X ".$height;
                    $media->media_type = 'Image';
                    $media->related_type = 'Category';
                    $media->related_id = $image->category_id;
                    $media->save();
                    $id = $media->id;
                    DB::table('categories')->where('category_code', $image->main_category_code)->update(['thumbnail_image'=>$id]);

                    //DB::table('main_category_tb')->where('category_id', $image->category_id)->update(['img_status'=>1]);
                }
            }
        }
    }

    public function update_sub_category_images()
    {
        $images = DB::table('sub_category_tb')->get();
        foreach ($images as $key => $image) {
            $img_url = $this->str_replace_first('~', 'https://pittappillilonline.com', $image->image_url);
            $destinationPath = public_path('uploads/category/primary/');
            $pathinfo = explode('/',$img_url);
            $lastElement = end($pathinfo);
            $extra = uniqid();
            $file_name =  str_replace(" ", '-', $extra.'_'.$lastElement);
            $destination = $destinationPath.$file_name;
            if($this->save_image( $img_url, $destination))
            {
                $success = $this->create_image('200', '200', public_path('uploads/category/200x200'), $file_name, asset('uploads/category/primary/'.$file_name));

                if($success)
                {
                    $media = new Media;
                    $media->file_name = $file_name;
                    $media->file_path = 'uploads/category/primary/' . $file_name;
                    $media->thumb_file_path = 'uploads/category/200x200/'.$file_name;
                    $media->file_type = mime_content_type($destination);
                    $media->file_size = filesize($destination);

                    $imagedetails = getimagesize($destination);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $media->dimensions = $width." X ".$height;
                    $media->media_type = 'Image';
                    $media->related_type = 'Category';
                    $media->related_id = $image->category_id;
                    $media->save();
                    $id = $media->id;
                    DB::table('categories')->where('category_code', $image->main_category_code)->update(['thumbnail_image'=>$id]);

                    //DB::table('sub_category_tb')->where('category_id', $image->category_id)->update(['img_status'=>1]);
                }
            }
        }
    }

    public function update_related_images()
    {
        ini_set('max_execution_time', '0');
        $images = DB::table('product_images_tb')->select('product_images_tb.id AS img_id', 'product_variants.id', 'product_images_tb.big_image_url')->join('product_variants', 'product_images_tb.product_code', '=', 'product_variants.code')->where('product_images_tb.is_main','!=', 1)->get();

        foreach ($images as $key => $image) {
            $img_url = $this->str_replace_first('~', 'https://pittappillilonline.com', $image->big_image_url);
            $destinationPath = public_path('uploads/products/');
            $pathinfo = explode('/',$img_url);
            $lastElement = strtolower(end($pathinfo));
            $extra = uniqid();
            $file_name =  str_replace(" ", '-',$lastElement);
            $destination = $destinationPath.$file_name;
            if($this->save_image( $img_url, $destination))
            {
                $success = $this->create_image('200', '200', public_path('uploads/products/200x200'), $file_name, asset('uploads/products/'.$file_name));

                if($success)
                {
                    $media = new Media;
                    $media->file_name = $file_name;
                    $media->file_path = 'uploads/products/' . $file_name;
                    $media->thumb_file_path = 'uploads/products/200x200/'.$file_name;
                    $media->file_type = mime_content_type($destination);
                    $media->file_size = filesize($destination);

                    $imagedetails = getimagesize($destination);
                    $width = $imagedetails[0];
                    $height = $imagedetails[1];
                    $media->dimensions = $width." X ".$height;
                    $media->media_type = 'Image';
                    $media->related_type = 'Products';
                    $media->related_id = $image->id;
                    $media->save();
                    $id = $media->id;
                    $image_variant = new ImageVariants;
                    $image_variant->variant_id = $image->id;
                    $image_variant->image_id = $id;
                    $image_variant->save();
                }
            }
            //DB::table('product_images_tb')->where('id', $image->img_id)->update(['status'=>1]);
        }
    }

    public function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }

    public function save_image($img,$fullpath){
        set_time_limit(0);
        $img = str_replace(" ", '%20', $img);
        $ch = curl_init ($img);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($fullpath)){
            unlink($fullpath);
        }
        $fp = fopen($fullpath,'x');
        fwrite($fp, $rawdata);
        fclose($fp);
        return true;
    }

    public function create_image($width, $height, $destination, $filename, $file)
    {
        try {
            // create new image with transparent background color
            $background = Image::canvas($width, $height);

            // read image file and resize it to 200x200
            // but keep aspect-ratio and do not size up,
            // so smaller sizes don't stretch
            $image = Image::make($file)->resize($width, $height, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            // insert resized image centered into background
            $background->insert($image, 'center');

            // save or do whatever you like
            $background->save($destination.'/'.$filename, 100);
            return true;
        }
        catch(\Intervention\Image\Exception\NotReadableException $e){
            return false;
        }
    }
}
