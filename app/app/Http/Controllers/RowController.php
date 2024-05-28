<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExcelRequest;
use App\Imports\RowsImport;
use App\Imports\RowsStore;
use App\Jobs\UploadExcelJob;
use App\Models\Row;
use App\Services\ImportService;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class RowController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(StoreExcelRequest $request)
    {
        $validated = $request->validated();
        Excel::import(new RowsImport, $validated['file']);

        $path_excel = ImportService::moveExcelAndPathExcel($request);

        $rowsStore = new RowsStore();

        Cache::put('start', 0);
        UploadExcelJob::dispatch($rowsStore, $path_excel);

        return back()->with('success', __('Excel_upload'));
    }

    public function rows()
    {
        $rows = Row::get()->groupBy('publish_date');
        return view('rows', [
            'rows' => $rows,
        ]);
    }
}
