<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class SearchTermsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('search_history')->select('search_history.search_term', 'search_history.count', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"),
        'search_history.updated_at')->leftJoin('users', 'search_history.user_id', '=', 'users.id')->get();
    }

    public function headings(): array
    {
        return [
            'Term',
            'Search Count',
            'User',
            'Last Updated',
        ];
    }
}
