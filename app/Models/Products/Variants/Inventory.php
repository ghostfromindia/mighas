<?php

namespace App\Models\Products\Variants;

use App\Models\BaseModel, App\Models\ValidationTrait, DB;

class Inventory extends BaseModel
{
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
    protected $table = 'product_inventory_by_vendor';


    protected $fillable = array('vendor_id', 'variant_id', 'barcode', 'retail_price', 'sale_price', 'landing_price', 'available_quantity');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function varient()
    {
        return $this->belongsTo('App\Models\Products\Variants', 'variant_id');
    }



    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function saveVariantByInventory($id, $data)
    {
        if(isset($data['inventory']))
            $inventories = $data['inventory'];
        else
            $inventories = [1];

        if($inventories)
        {
            foreach ($inventories as $key => $value) {
                $check_exist = static::where('vendor_id', $value)->where('variant_id', $id)->first();
                $quantity = $data['quantity'];
                $retail_price = $data['retail_price'];
                $sale_price = $data['sale_price'];
                $landing_price = isset($data['landing_price'])?$data['landing_price']:$data['retail_price'];
                if($check_exist)
                {
                    //echo "entered";exit;
                    $quantity = $check_exist->available_quantity;
                    $retail_price = $check_exist->retail_price;
                    $sale_price = $check_exist->sale_price;
                    $landing_price = $check_exist->landing_price;
                    if(is_int((int)$data['quantity']))
                    {
                        $quantity = (int)$data['quantity'];
                        DB::table('product_stock_history')->insert(
                            ['inventory_id' => $check_exist->id, 'last_stock' => $check_exist->available_quantity, 'added_stock'=>$quantity]
                        );
                    }
                    
                    if($data['retail_price'] !='' || $data['sale_price']!='')
                    {
                        if($data['retail_price'] !='')
                            $retail_price = $data['retail_price'];
                        if($data['sale_price']!='')
                            $sale_price = $data['sale_price'];
                        DB::table('product_price_history')->insert(
                            ['inventory_id' => $check_exist->id, 'retail_price' => $check_exist->retail_price, 'sale_price'=>$check_exist->sale_price, 'new_retail_price'=>$retail_price,
                            'new_sale_price'=>$sale_price]
                        );
                    }
                    
                }
                $inventrory = static::updateOrCreate([
                    'vendor_id' => $value,
                    'variant_id' => $id,
                ],[
                    'vendor_id' => $value,
                    'variant_id' => $id,
                    'barcode' => isset($data['barcode'])?$data['barcode']:null,
                    'retail_price' =>$retail_price,
                    'sale_price' =>$sale_price,
                    'landing_price' => $landing_price,
                    'available_quantity' => $quantity,
                ]);
            }
        }
        return true;
    }

}