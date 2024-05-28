<?php

namespace App\Imports;

use App\Jobs\UploadExcelJob;
use App\Models\Row;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RowsStore implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();

        $limit = 1000;
        $start = Cache::get('start', 0);
        echo "Start: " . $start . "\n";

        for ($i = $start; $i < $start + $limit && $i < count($rows); $i++) {
            $row = $rows[$i];
            if (!array_filter($row)) continue;
            Row::create([
                'id' => $row['id'],
                'name' => $row['name'],
                'publish_date' => $row['date'],
            ]);
        }

        Cache::put('start', $i);
        if ($i < count($rows)) {
            $path_excel = public_path('excel/test.xlsx');
            $rowsStore = new RowsStore();
            UploadExcelJob::dispatch($rowsStore, $path_excel);
        }
    }
}
