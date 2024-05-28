<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RowsImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        $rows_filtered = array();
        foreach ($rows as $row) {
            if(array_filter($row)) $rows_filtered[] = $row;
        }

//        Вариант через коллекцию
//        $rows = $rows->toArray();
//        $rows_filtered = collect($rows)->filter(function ($row) {
//            return array_filter($row);
//        })->toArray();

        Validator::make($rows_filtered, [
            '*.id' => 'required',
            '*.name' => 'required',
            '*.date' => 'required',
        ])->validate();
    }
}
