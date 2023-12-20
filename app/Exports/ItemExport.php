<?php

namespace App\Exports;
use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Item::query();
    }

    public function headings(): array
    {
        return [
            'Item ID',
            'Item Name',
            'Item Code',
            'Internal Item Name',
            'Unit Price',
            'HSN Code',
            'Item Type ID',
            'Unit Type ID',
            'Cut',
            'Purchase Rate',
            'Sale Rate',
            'IGST',
            'SGST',
            'CGST',
            'Item GSM',
            'Remarks',
            'Status',
            'Created',
            'Modified',
            'Created By',
            'Modified By',
            'Is Consumable',
        ];
    }
}



?>