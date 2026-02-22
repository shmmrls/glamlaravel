<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Sample row so admin knows the format
        return [
            [1, 'Sample Product', 'Sample description', 299.00, 50, 'img_name', 0],
        ];
    }

    public function headings(): array
    {
        return [
            'category_id',
            'product_name',
            'description',
            'price',
            'quantity',
            'main_img_name',
            'is_featured',
        ];
    }
}