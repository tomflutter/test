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
     * Halaman index
     */
    public function index()
    {
        return view('master_items.index.index');
    }

    /**
     * Search / Filter (AJAX)
     */
    public function search(Request $request)
    {
        $query = MasterItem::query();

        if ($request->filled('kode')) {
            $query->where('kode', $request->kode);
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if ($request->filled('hargamin')) {
            $query->where('harga_beli', '>=', $request->hargamin);
        }

        if ($request->filled('hargamax')) {
            $query->where('harga_beli', '<=', $request->hargamax);
        }

        $data = $query->select(
            'id',
            'kode',
            'nama',
            'jenis',
            'harga_beli',
            'laba',
            'supplier'
        )->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'data'   => $data,
        ]);
    }

    /**
     * Form tambah / edit
     */
    public function formView($method, $id = null)
    {
        $item = $method === 'new'
            ? new MasterItem()
            : MasterItem::with('categories')->findOrFail($id);

        $categories = Category::all();

        return view('master_items.form.index', compact('item', 'method', 'categories'));
    }

    /**
     * Detail item
     */
    public function singleView($kode)
    {
        $item = MasterItem::with('categories')
            ->where('kode', $kode)
            ->firstOrFail();

        return view('master_items.single.index', compact('item'));
    }

    /**
     * Simpan / Update
     */
    public function formSubmit(Request $request, $method, $id = null)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'laba'       => 'required|numeric|min:0|max:100',
            'supplier'   => 'required|string',
            'jenis'      => 'required|string',
            'categories' => 'nullable|array',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $item = $method === 'new'
            ? new MasterItem()
            : MasterItem::findOrFail($id);

        $item->nama       = $request->nama;
        $item->harga_beli = $request->harga_beli;
        $item->laba       = $request->laba;
        $item->supplier   = $request->supplier;
        $item->jenis      = $request->jenis;

// upload foto
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/items'), $filename);
            $item->foto = $filename;
        }

        $item->save();

// generate kode setelah ada ID
        if ($method === 'new') {
            $item->kode = str_pad($item->id, 5, '0', STR_PAD_LEFT);
            $item->save();
        }

        $item->categories()->sync($request->categories ?? []);

        return redirect('master-items')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Hapus item
     */
    public function delete($id)
    {
        MasterItem::findOrFail($id)->delete();
        return redirect('master-items')->with('success', 'Data berhasil dihapus');
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

        $data = [[
            'Nama Item'  => $item->nama,
            'Kategori'   => $item->categories->pluck('nama')->join(', '),
            'Supplier'   => $item->supplier,
            'Harga Beli' => $item->harga_beli,
            'Laba (%)'   => $item->laba,
            'Harga Jual' => $item->harga_beli + ($item->harga_beli * $item->laba / 100),
        ]];

        return Excel::download(
            new \App\Exports\ArrayExport($data),
            'master_item_' . $item->kode . '.xlsx'
        );
    }
}
