<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('sub_category_tb')->select("sub_category_code", "main_category_code", 'sub_category_name')->where('status', 1)->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Main Category Code',
            'Title'
        ];
    }
}
