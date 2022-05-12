<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProductImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        // dd($row[0]);
        $group = Product::firstOrCreate([
            //
            'UNIQUE_KEY'                => $row['unique_key'],
            'PRODUCT_TITLE'             => $row['product_title'],
            'PRODUCT_DESCRIPTION'       => $row['product_description'],
            'STYLE#'                    => $row['style'],
            'SANMAR_MAINFRAME_COLOR'    => $row['sanmar_mainframe_color'],
            'SIZE'                      => $row['size'],
            'COLOR_NAME'                => $row['color_name'],
            'PIECE_PRICE'               => $row['piece_price'],
        ]);
    }

    public function batchSize(): int
    {
        return 50;
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
}
