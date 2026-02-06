<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // package barryvdh/laravel-dompdf
use PDF;
// package maatwebsite/excel

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->kode) {
            $query->where('kode', 'like', '%' . $request->kode . '%');
        }

        $categories = $query->get();

        return view('categories.index', compact('categories'));
    }

    public function formView($method, $id = null)
    {
        $category = $method == 'edit' ? Category::findOrFail($id) : new Category;
        return view('categories.form', compact('category', 'method'));
    }

    public function formSubmit(Request $request, $method, $id = null)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:categories,kode,' . ($id ?? 'NULL') . ',id',
        ]);

        $category = $method == 'edit' ? Category::findOrFail($id) : new Category;
        $category->fill($data);
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Kategori tersimpan!');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori dihapus!');
    }

    public function singleView($id)
    {
        $category = Category::with('items')->findOrFail($id);
        return view('categories.single', compact('category'));
    }

    public function downloadPdf($id)
    {
        $category = Category::with('items')->findOrFail($id);

        $pdf = PDF::loadView('categories.pdf', compact('category'));
        return $pdf->download('kategori_' . $category->kode . '.pdf');
    }

    public function downloadExcel()
    {
        $items = MasterItem::with('categories')->get();

        $data = $items->map(function ($item, $index) {
            return [
                'No'            => $index + 1,
                'Nama Kategori' => $item->categories->pluck('nama')->implode(', '),
                'Nama Item'     => $item->nama,
                'Supplier'      => $item->supplier,
                'Harga'         => $item->harga_beli,
                'Laba'          => $item->laba,
                'Harga Jual'    => $item->harga_beli + ($item->harga_beli * $item->laba / 100),
            ];
        });

        return Excel::download(new \App\Exports\ArrayExport($data->toArray()), 'master_items.xlsx');
    }
}
