@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Kategori: {{ $category->nama }}</h3>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Kembali</a>
    <a href="{{ url('categories/pdf/'.$category->id) }}" class="btn btn-success mb-3">Download PDF</a>

    <table class="table table-bordered">
        <tr>
            <th>Kode</th>
            <td>{{ $category->kode }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $category->nama }}</td>
        </tr>
    </table>

    <h4>Daftar Item</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Item</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Laba (%)</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($category->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ $item->harga_beli }}</td>
                <td>{{ $item->laba }}</td>
                <td>{{ $item->harga_beli + ($item->harga_beli * $item->laba / 100) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
