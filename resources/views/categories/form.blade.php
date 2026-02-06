@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $method == 'edit' ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('categories.submit', ['method'=>$method, 'id'=>$category->id ?? 0]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $category->kode ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $category->nama ?? '') }}" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
