<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Controllers\Encoding;

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
            'UNIQUE_KEY'                => Encoding::fixUTF8($row['unique_key']),
            'PRODUCT_TITLE'             => Encoding::fixUTF8($row['product_title']),
            'PRODUCT_DESCRIPTION'       => Encoding::fixUTF8($row['product_description']),
            'STYLE#'                    => Encoding::fixUTF8($row['style']),
            'SANMAR_MAINFRAME_COLOR'    => Encoding::fixUTF8($row['sanmar_mainframe_color']),
            'SIZE'                      => Encoding::fixUTF8($row['size']),
            'COLOR_NAME'                => Encoding::fixUTF8($row['color_name']),
            'PIECE_PRICE'               => Encoding::fixUTF8($row['piece_price']),
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
