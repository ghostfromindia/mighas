<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesHistoryExport implements FromCollection, WithHeadings
{
    use Exportable;

    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            'Product',
            'Quantity',
            'Sales Price',
            'MRP',
            'Discount',
            'HSN Code',
            'CGST',
            'SGST',
            'IGST',
            'Date'
        ];
    }
}