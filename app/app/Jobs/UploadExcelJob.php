<?php

namespace App\Jobs;

use App\Imports\RowsStore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class UploadExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rowsStore;
    protected $path_excel;

    public function __construct(RowsStore $rowsStore, $path_excel)
    {
        $this->rowsStore = $rowsStore;
        $this->path_excel = $path_excel;
    }

    public function handle(): void
    {
        Excel::import($this->rowsStore, $this->path_excel);
    }
}
