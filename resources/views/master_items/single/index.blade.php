@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('master-items') }}" class="btn btn-secondary">
                    Kembali ke Daftar Item
                </a>
            </div>

            <div class="card">
                <div class="card-header">Master Item</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $item->nama }}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>{{ $item->harga_beli }}</td>
                        </tr>
                        <tr>
                            <th>Laba</th>
                            <td>{{ $item->laba }}%</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>{{ $item->harga_beli + ($item->harga_beli * $item->laba / 100) }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $item->supplier }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $item->jenis }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                @if($item->categories->isEmpty())
                                    <em>-</em>
                                @else
                                    <ul>
                                        @foreach($item->categories as $cat)
                                            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a class="btn btn-info" href="{{ url('master-items/form/edit/'.$item->id) }}">
                        Edit
                    </a>

                    <a class="btn btn-danger"
                       href="{{ url('master-items/delete/'.$item->id) }}"
                       onclick="return confirm('Yakin hapus data ini?')">
                        Delete
                    </a>

                    <a class="btn btn-primary"
                       href="{{ url('master-items/excel/'.$item->id) }}">
                        Download Excel
                    </a>

                    <a class="btn btn-secondary"
                       href="{{ url('master-items/pdf/'.$item->id) }}">
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
