@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Kategori</h3>
    <div class="mb-3">
        <a href="{{ route('categories.form', ['method'=>'new']) }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ request('nama') }}">
        </div>
        <div class="col-md-4">
            <input type="text" name="kode" class="form-control" placeholder="Kode" value="{{ request('kode') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-secondary">Filter</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index => $cat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cat->kode }}</td>
                <td>{{ $cat->nama }}</td>
                <td>
                    <a href="{{ route('categories.form', ['method'=>'edit','id'=>$cat->id]) }}" class="btn btn-sm btn-info">Edit</a>
                    <a href="{{ route('categories.delete', $cat->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori?')">Hapus</a>
                    <a href="{{ url('categories/view/'.$cat->id) }}" class="btn btn-sm btn-success">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
