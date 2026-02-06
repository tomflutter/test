<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class MasterItemsController extends Controller
{
    /**
     * Menampilkan halaman index
     */
    public function index()
    {
        $items = MasterItem::with('categories')->orderBy('id')->get();
        return view('master_items.index.index', compact('items'));
    }

    /**
     * Pencarian item
     */
    public function search(Request $request)
    {
        $query = MasterItem::query();

        if (!empty($request->kode)) {
            $query->where('kode', $request->kode);
        }

        if (!empty($request->nama)) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if (!empty($request->hargamin)) {
            $query->where('harga_beli', '>=', $request->hargamin);
        }

        if (!empty($request->hargamax)) {
            $query->where('harga_beli', '<=', $request->hargamax);
        }

        $data = $query->with('categories')
                      ->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')
                      ->orderBy('id')
                      ->get();

        return response()->json([
            'status' => 200,
            'data'   => $data
        ]);
    }

    /**
     * Form tambah / edit
     */
    public function formView($method, $id = 0)
    {
        if ($method === 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
        }

        $categories = Category::all();

        return view('master_items.form.index', compact('item', 'method', 'categories'));
    }

    /**
     * View detail satu item
     */
    public function singleView($kode)
    {
        $item = MasterItem::with('categories')->where('kode', $kode)->firstOrFail();
        return view('master_items.single.index', ['data' => $item]);
    }

    /**
     * Simpan / update data item
     */
    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method === 'new') {
            $item = new MasterItem;
            $kode = str_pad(MasterItem::max('id') + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $item = MasterItem::findOrFail($id);
            $kode = $item->kode;
        }

        $request->validate([
    'nama'       => 'required|string|max:255',
    'harga_beli' => 'required|numeric|min:0',
    'laba'       => 'required|numeric|min:0|max:100',
    'supplier'   => 'required|string',
    'jenis'      => 'required|string',
    'categories' => 'array'
]);

if ($request->hasFile('foto')) {
    $file = $request->file('foto');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('uploads/items'), $filename);
    $item->foto = $filename;
}


        $item->nama       = $request->nama;
        $item->harga_beli = $request->harga_beli;
        $item->laba       = $request->laba;
        $item->kode       = $kode;
        $item->supplier   = $request->supplier;
        $item->jenis      = $request->jenis;
        $item->save();

        // Sync kategori
        $item->categories()->sync($request->categories ?? []);

        return redirect('master-items')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Hapus item
     */
    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);
        $item->delete();

        return redirect('master-items')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Update data acak (untuk testing)
     */
    public function updateRandomData()
    {
        $items = MasterItem::all();

        foreach ($items as $item) {
            $item->harga_beli = rand(100, 1000000);
            $item->laba       = rand(10, 99);
            $item->kode       = str_pad($item->id, 5, '0', STR_PAD_LEFT);
            $item->supplier   = $this->getRandomSupplier();
            $item->jenis      = $this->getRandomJenis();
            $item->save();
        }

        return redirect()->back()->with('success', 'Data acak berhasil diperbarui');
    }

    private function getRandomSupplier()
    {
        $suppliers = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        return $suppliers[array_rand($suppliers)];
    }

    private function getRandomJenis()
    {
        $jenis = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        return $jenis[array_rand($jenis)];
    }

    /**
     * Download PDF
     */
    public function downloadPdf($id)
    {
        $item = MasterItem::with('categories')->findOrFail($id);
        $pdf  = PDF::loadView('master_items.pdf', compact('item'));

        return $pdf->download('master_item_' . $item->kode . '.pdf');
    }

    /**
     * Download Excel
     */
    public function downloadExcelItem($id)
    {
        $item = MasterItem::with('categories')->findOrFail($id);

        $data = collect([$item])->map(function ($item, $index) {
            return [
                'No'            => $index + 1,
                'Nama Kategori' => $item->categories->pluck('nama')->join(', '),
                'Nama Item'     => $item->nama,
                'Supplier'      => $item->supplier,
                'Harga Beli'    => $item->harga_beli,
                'Laba (%)'      => $item->laba,
                'Harga Jual'    => $item->harga_beli + ($item->harga_beli * $item->laba / 100),
            ];
        });

        return Excel::download(new \App\Exports\ArrayExport($data->toArray()), 'master_item_' . $item->kode . '.xlsx');
    }
}
