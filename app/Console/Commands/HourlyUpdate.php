<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use App\Models\Products\Variants as ProductVariant;
use DB, Image;

class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update image from live site to local';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $images = DB::table('product_images_tb')->select('product_images_tb.id AS img_id', 'products_tb.id', 'product_images_tb.big_image_url')->join('products_tb', 'product_images_tb.product_code', '=', 'products_tb.product_code')->where('product_images_tb.is_main', 1)->where('product_images_tb.status', 0)->take(25)->get();
        foreach ($images as $key => $image) {
            $img_url = str_replace('~', 'https://pittappillilonline.com', $image->big_image_url);
            $destinationPath = public_path('uploads/products/');
            $pathinfo = explode('/',$img_url);
            $lastElement = end($pathinfo);
            $extra = uniqid();
            $file_name =  str_replace(" ", '-', $extra.'_'.$lastElement);
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
            DB::table('product_images_tb')->where('id', $image->img_id)->update(['status'=>1]);
        }
    }

    function save_image($img,$fullpath){
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
