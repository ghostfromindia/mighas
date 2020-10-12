<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('products')->select("products.product_name", "products.slug", "product_inventory_by_vendor.retail_price", "product_inventory_by_vendor.sale_price", "product_inventory_by_vendor.available_quantity", "products.hsn_code", "products.cgst", "products.sgst")->join('categories', 'products.category_id', '=', 'categories.id')->join('product_variants', 'products.id', '=', 'product_variants.products_id')->join('product_inventory_by_vendor', 'product_variants.id', '=', 'product_inventory_by_vendor.variant_id')->where('products.is_active', 1)->where('is_warranty_product', 0)->whereNull('products.deleted_at')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Product Code',
            'MRP',
            'Sale Price',
            'Quantity',
            'HSN Code',
            'CGST',
            'SGST'
        ];
    }
}
