<?php

namespace App\Models;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;
use App\Models\Products\Variants;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offers extends BaseModel
{
    use SoftDeletes;
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offers';


    protected $fillable = array('offer_name','slug', 'type', 'vendor_id', 'validity_start_date', 'validity_end_date', 'applicable_for_full_order', 'discount_type', 'amount', 'percentage', 'min_purchase_amount', 'max_discount_amount', 'is_active', 'browser_title', 'meta_keywords', 'meta_description');

    protected $dates = ['created_at','updated_at'];

    public $uploadPath = array(
        
    );


    protected function setRules() {

        $this->val_rules = array(
            'offer_name'=> 'required',
            'type' => 'required',
            'validity_start_date' => 'required',
            'validity_end_date' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Offers\OfferCategories', 'offers_id');
    }

    public function free_products()
    {
        return $this->hasMany('App\Models\Offers\OfferComboFreeProducts', 'offers_id');
    }

    public function group_offer()
    {
        return $this->hasOne('App\Models\Offers\OfferGroups', 'offers_id');
    }

    public function price_offers()
    {
        return $this->hasMany('App\Models\Offers\OfferPriceProducts', 'offers_id');
    }

    public function combo_offers()
    {
        return $this->hasMany('App\Models\Offers\OfferComboProducts', 'offers_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function offer_image(){
        return $this->rec();
    }
    function rec(){
        $product =  DB::table('offers_data')->where('offer',$this->id)->inRandomOrder()->first();
        if($product){
            $product = $product->product;
        }
        $product = Variants::find($product);
        if(!empty($product->media)){
            return $product->media->file_path;
        }else{
            return '';
        }
    }

    public static function isValid($id){
        $now = date('Y-m-d');
        $offer = Offers::where('id',$id)->where('validity_start_date','<=',$now)->where('validity_end_date','>=',$now)->where('is_active',1)->first();

        if($offer){
            return true;
        }else{
            return false;
        }
    }

     public static function getComboProducts($offer_id){
        // Return every products in the combo-buy
        $offer_buy_products = DB::table('offer_combo_products as o')
            ->join('product_variants as p', 'p.id', '=', 'o.products_id')
            ->join('product_inventory_by_vendor as piv', 'p.id', '=', 'piv.variant_id')
            ->where('offers_id',$offer_id)
            ->select('p.id as products_id','piv.sale_price as sale_price','piv.retail_price')->get();
        if(count($offer_buy_products)<=0){
            return false;
        }else{
            return $offer_buy_products;
        }

    }

    public static function getFreeProducts($offer_id){
        // Return every products in the combo-buy
        $offer_get_products = DB::table('offer_combo_free_products as o')
            ->join('product_variants as p', 'p.id', '=', 'o.products_id')
            ->join('product_inventory_by_vendor as piv', 'p.id', '=', 'piv.variant_id')
            ->where('offers_id',$offer_id)
            ->select('p.id as products_id','piv.sale_price as sale_price','piv.retail_price','o.type as type','o.max_discount_amount as max_discount_amount','o.discount_percentage as discount_percentage','o.fixed_price as fixed_price','o.discount_amount as discount_amount')->get();
        if(count($offer_get_products)<=0){
            return false;
        }else{
            return $offer_get_products;
        }

    }




}