<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderHistoryExport implements FromCollection, WithHeadings
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
            'Transaction Id',
            'Order Reference No.',
            'Mobile No.',
            'Name',
            'Address1',
            'Address2',
            'Landmark',
            'City',
            'Pincode',
            'Address Type',
            'Product',
            'Category',
            'Quantity',
            'Sale Price',
            'Status',
            'Customer Instructions',
            'Order Date',
            'Payment Method'
        ];
    }
}