<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller, Input, Mail,Auth, Image, File AS FileInput, DB;
use App\Models\Leads;
use App\Models\Agency\PurchasedLeads;
use App\Models\Agency\UsageHistory;
use App\Models\Agencies;
use App\Models\Settings;
use Jenssegers\Agent\Agent;
use App\Models\Lead\LeadCategories;
use App\Models\Lead\LeadTypes;
use App\Models\File;
use App\Models\Media;
use App\Models\Products\Variants\Images AS ImageVariants;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Mail\Message;

abstract class BaseController extends Controller {

    protected $route, $views;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->route = $this->views = 'admin';
    }

    public  function uploadFile($fileInput = 'image', $filePath = 'uploads/', $varient=array()) {
        
        $destinationPath = public_path($filePath);
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Input::file($fileInput);

            
        
        if ( (is_object($fileInput) || Input::hasFile($fileInput)) && $file->isValid()) {
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();
            $fileType = $file->getMimeType();

            $fileDimensions = null;
            if(substr($file->getMimeType(), 0, 5) == 'image') {
                $type = "Image";
                $imagedetails = getimagesize($file);
                $width = $imagedetails[0];
                $height = $imagedetails[1];
                $fileDimensions = $width." X ".$height;
                $thumb_image = '';
            }
            else if(substr($file->getMimeType(), 0, 5) == 'video') {
                $type = "Video";
                $thumb_image = 'assets/images/docs/video.jpg';
            }
            else if(substr($file->getMimeType(), 0, 5) == 'audio') {
                $type = "Audio";
                $thumb_image = 'assets/images/docs/audio.png';
            }
            else if($file->getMimeType() == 'application/msword') {
                $type = "DOC";
                $thumb_image = 'assets/images/docs/doc.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $type = "DOCX";
                $thumb_image = 'assets/images/docs/docx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-excel') {
                $type = "XLS";
                $thumb_image = 'assets/images/docs/xls.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $type = "XLSX";
                $thumb_image = 'assets/images/docs/xlsx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-powerpoint') {
                $type = "PPT";
                $thumb_image = 'assets/images/docs/ppt.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                $type = "PPTX";
                $thumb_image = 'assets/images/docs/pptx.png';
            }
            else if($file->getMimeType() == 'application/pdf') {
                $type = "PDF";
                $thumb_image = 'assets/images/docs/pdf.jpg';
            }
            else {
                $type = "File";
                $thumb_image = 'assets/images/docs/file.png';
            }

            
            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = $file_parts['filename'];
            $file_name = Str::slug($file_name, '-');
            $i = 0;
            $extra = uniqid();
            while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                $i++;
                $extra = '_' . $i;
            }
            $fileName = $file_name . $extra . '.' . $file_ext;

            if(!FileInput::isDirectory($destinationPath)) {
                // path does not exist
                FileInput::makeDirectory($destinationPath, 0755, true);
            }
            $success = false;
            if($type == 'Image')
            {
                $file_obj = Image::make($file);
                if($file_obj->save($destinationPath.$fileName))
                {
                    $success = true;

                    //save thumbnail
                    $thumbDestPath = 'public/uploads/thumbnails';
                    if(!FileInput::isDirectory($thumbDestPath)) {
                        FileInput::makeDirectory($thumbDestPath, 0755, true);
                    }
                    $this->create_image(200, 200, $thumbDestPath, $fileName, $file);
                    $thumb_image = 'uploads/thumbnails/'.$fileName;
                    if($varient)
                    {
                        $image_varients = DB::table('media_types')->select('media_settings.width', 'media_settings.height', 'media_types.path')->join('media_settings', 'media_settings.type_id', '=', 'media_types.id')->whereNull('media_settings.deleted_at')->whereIn('media_types.type', $varient)->get();
                        if($image_varients)
                        {
                            foreach ($image_varients as $key => $img_varient) {
                                $folder = $img_varient->width.'X'.$img_varient->height;
                                $varient_desctination_path = $img_varient->path.'/'.$folder;
                                if(!FileInput::isDirectory($varient_desctination_path)) {
                                    FileInput::makeDirectory($varient_desctination_path, 0755, true);
                                }
                                $this->create_image($img_varient->width, $img_varient->height, $varient_desctination_path, $fileName, $file);

                            }
                        }
                    }
                }

            }
            elseif( $file->move($destinationPath, $fileName) ) {
                $success = true;
            }
            if($success)
            {
                $result['filename'] = $fileName;
                $result['filepath'] = $filePath . $fileName;
                $result['filesize'] = $fileSize;
                $result['filedimensions'] = $fileDimensions;
                $result['mediatype'] = $type;
                $result['mediathumb'] = $thumb_image;
                $result['filetype'] = $fileType;
                $result['success'] = true;
            }
            else
                $result['error'] = 'Something wrong happend, please try again.';
        } else {
            $result['error'] = 'No file selected or Invalid file.';         
        }
        return $result;
    }

    public function getVariantGallery($id)
    {
        $gallery = DB::table('media_library')->select('media_library.id', 'media_library.file_path', 'media_library.thumb_file_path', 'product_variant_images.title', 'product_variant_images.alt')->join('product_variant_images', 'media_library.id', '=', 'product_variant_images.image_id')->join('product_variants', 'product_variants.id', '=', 'product_variant_images.variant_id')->where('product_variants.id', $id)->orderBy('product_variant_images.created_at', 'DESC')->get();
        return $gallery;
    }

    public function create_image($width, $height, $destination, $filename, $file)
    {
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

    public static function slug($slug){
        return strtolower(preg_replace( '/[-+()^ $%&.*~]+/', '-', $slug));
    }

    public function saveMedia($upload)
    {
        $media = new Media;
        $media->file_name = $upload['filename'];
        $media->file_path = $upload['filepath'];
        $media->thumb_file_path = $upload['mediathumb'];
        $media->file_type = $upload['filetype'];
        $media->file_size = $upload['filesize'];
        $media->dimensions = $upload['filedimensions'];
        $media->media_type = $upload['mediatype'];
        if(isset($upload['related_type']) && $upload['related_type']!='' && isset($upload['related_id']) && $upload['related_id']!='')
        {
            $media->related_type = $upload['related_type'];
            $media->related_id = $upload['related_id'];
        }
        $media->save();
                
        $data = array(
                    'name' => $media->file_name,
                    'size' => $media->file_size,
                    'id' => $media->id,
                    'original_file' => \URL::to('').'/public/'.$media->file_path,
                    'type' => $media->file_type,
                    'url' => $media->thumb_file_path,
                );
        return $data;
    }

    public function saveGallery($variant_id, $data, $save_type="add")
    {
        if($save_type != 'add')
            ImageVariants::where('variant_id', $variant_id)->delete();
        if(isset($data['media_id']))
        {
            foreach ($data['media_id'] as $key => $media) {
                if($media != '')
                {
                    $gallery = new ImageVariants;
                    $gallery->variant_id = $variant_id;
                    $gallery->image_id = $media;
                    $gallery->title = $data['title'][$key];
                    $gallery->alt = $data['alt'][$key];
                    $gallery->save();
                }
            }
        }
        return true;
    }

    public static function upload_file($file,$foldername,$alt=null,$notes=null){
        $supported_image = array('gif','jpg','jpeg','png','pdf','docs');
        $ext = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize();
        if (in_array($ext, $supported_image)){

            if ($file->isValid()) {
                $filename = BaseController::slug($file->getClientOriginalName()).date('ymdHis').'.'.$file->getClientOriginalExtension();
                $path = public_path().'/uploads/'.$foldername;
                $file->move($path.'/', $filename);
                $url = 'public/uploads/'.$foldername.'/'.$filename;
                array('url','alt','file_size','file_extension','file_name','notes','status');

                $file = new File;
                $file->file_name = $filename;
                $file->url = $url;
                $file->alt = $alt;
                $file->file_size = $size;
                $file->file_extension = $ext;
                $file->notes = $notes;
                $file->status = 'active';
                $file->save();

                $data['status'] = true;
                $data['data'] = $file->id;
                return $data;
            }else {
                $data['status'] = false;
                $data['data'] = 'An error occurred while uploading the file.';
                return $data;
            }
        }
    }

      public static function sms_send($mobile_numbers,$message){
        //Please Enter Your Details
        $user="pittappillilbilling";
        //your username
        $password="billing123";
        //your password
        $mobilenumbers=$mobile_numbers;
        //enter Mobile numbers comma seperated
        $message = $message;
        //enter Your Message
        $senderid="PTPLIL";
        //Your senderid
        $url="http://sapteleservices.com/SMS_API/sendsms.php";

        $message = urlencode($message);
        $ch = curl_init();
        if (!$ch)
        {
            die("Couldn't initialize a cURL handle");
        }

        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//        echo "username=$user&password=$password&mobile=$mobilenumbers&message=$message&sendername=$senderid&routetype=1";
        curl_setopt ($ch, CURLOPT_POSTFIELDS,"username=$user&password=$password&mobile=$mobilenumbers&message=$message&sendername=$senderid&routetype=1");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
        //$ret = curl_setopt($ch, CURLOPT_PROXY, "162.252.85.27");
        $curlresponse = curl_exec($ch);
        // execute if(curl_errno($ch)) echo 'curl error : '. curl_error($ch);
        if (empty($ret))
        {
            // some kind of an error happened die(curl_error($ch));
            curl_close($ch);
            // close cURL handler
        }
        else
        {
            $info = curl_getinfo($ch);
            $curlresponse = curl_exec ($ch);
//            print_r($curlresponse);
            curl_close($ch);
            // close cURL handler echo $curlresponse;
            return true;
        }
        return false;
    }

    public static function mail_send($mail,$message,$subject){
        Mail::to($mail)->send(new Message($message,$subject));
    }

    public static function send_notification($message,$subject){
        $user = Auth::user();
        $email = $user->email;
        $mobile = $user->username;
        $mobile = preg_replace("/[^0-9]/", "", $mobile);


        if(strlen($mobile) == 10){
            BaseController::sms_send($mobile,$message);
        }

        if($email){
            BaseController::mail_send($email,$message,$subject);
        }


    }
    
    
    
    public static function send_mail_notification($email,$message,$subject){

        if($email){
            BaseController::mail_send($email,$message,$subject);
        }

    }

    public static function send_sms_notification($mobile,$message){

        $mobile = preg_replace("/[^0-9]/", "", $mobile);

        if(strlen($mobile) == 10){
            BaseController::sms_send($mobile,$message);
        }

    }
    
    
    public static function send_admin_mail_notification($message,$subject){
            BaseController::mail_send('admin@pittappillil.com',$message,$subject);
            BaseController::mail_send('ho@pittappillil.com',$message,$subject);
    }


    public static function getIndianCurrency(float $number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public  function setKey($key_code, $value, $type)
    {
        $key_code = BaseController::slug($key_code);
        if($type == 'text'){
            $key = Settings::where('code',$key_code)->first();
            if(!$key){
                $key = new Settings();
            }
            $key->code = $key_code;
            $key->value = $value;
            $key->media_id = null;
            $key->type = 'Text';
            $key->save();
        }

        if($type == 'image'){
            $key = Settings::where('code',$key_code)->first();
            if(!$key){
                $key = new Settings();
            }

            $upload = $this->uploadFile($value, 'uploads/settings/');
            $result = $this->saveMedia($upload);
            $key->code = $key_code;
            $key->value = $result['name'];
            $key->media_id = $result['id'];
            $key->type = 'Image';
            $key->save();
        }

    }

}