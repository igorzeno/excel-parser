<?php

namespace App\Services;

use Illuminate\Http\Request;

class ImportService
{
    public static function moveExcelAndPathExcel(Request $request): string
    {
        $request->file->move(public_path('excel'), 'test.xlsx');
        return public_path('excel/test.xlsx');
    }
}
