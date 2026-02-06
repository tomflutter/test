<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterItemsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $items = MasterItem::with('categories')->get();

        return $items->map(function($item, $index) {
    return [
        'No' => $index + 1,
        'Nama Kategori' => $item->categories->pluck('nama')->join(', '),
        'Nama Item' => $item->nama,
        'Supplier' => $item->supplier,
        'Harga' => $item->harga_beli,
        'Laba' => $item->laba,
        'Harga Jual' => $item->harga_beli + ($item->harga_beli * $item->laba / 100),
    ];
});

    }

    public function headings(): array
    {
        return ['No', 'Nama Kategori', 'Nama Item', 'Supplier', 'Harga', 'Laba', 'Harga Jual'];
    }
}
