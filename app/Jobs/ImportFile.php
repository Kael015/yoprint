<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DataFile;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file_name;
    protected $file_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_name)
    {
        //
        $this->file_name = $file_name;
        $data_file = DataFile::where('file_name', $file_name)->limit(1)->get();
        $this->file_id = $data_file[0]->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        
        // dd($file_id);
        // dd( public_path('\data_file'));
        DB::table('file')
            ->where('id', $this->file_id)
            ->update(['status' => 'processing']);

        Excel::import(new ProductImport, $this->file_name, 'data_file');

        DB::table('file')
            ->where('id', $this->file_id)
            ->update(['status' => 'completed']);
    }

    public function failed(Throwable $exception)
    {
        DB::table('file')
            ->where('id', $this->file_id)
            ->update(['status' => 'failed']);
    }
}
