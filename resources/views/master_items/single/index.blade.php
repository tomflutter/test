@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('master-items') }}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="card">
                <div class="card-header">Master Item</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $data->nama }}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>{{ $data->harga_beli }}</td>
                        </tr>
                        <tr>
                            <th>Laba</th>
                            <td>{{ $data->laba }}%</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>{{ $data->harga_beli + ($data->harga_beli * $data->laba / 100) }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $data->supplier }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $data->jenis }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                @if($data->categories->isEmpty())
                                    <em>-</em>
                                @else
                                    <ul>
                                        @foreach($data->categories as $cat)
                                            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a class="btn btn-info" href="{{ url('master-items/form/edit/'.$data->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ url('master-items/delete/'.$data->id) }}" 
                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    <!-- Tambahkan tombol cetak/download -->
    <a class="btn btn-primary" href="{{ url('master-items/excel/'.$data->id) }}">
    <a class="btn btn-secondary" href="{{ url('master-items/pdf/'.$data->id) }}">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection