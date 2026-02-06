<form method="POST" enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" readonly value="{{ $item->kode }}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group">
        <label>Laba (%)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    {{-- Supplier --}}
    @php $supplier = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" name="supplier" required>
            <option value="">--Pilih--</option>
            @foreach(['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'] as $sup)
                <option value="{{ $sup }}" @selected($supplier == $sup)>{{ $sup }}</option>
            @endforeach
        </select>
    </div>

    {{-- Jenis --}}
    @php $jenis = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" name="jenis" required>
            <option value="">--Pilih--</option>
            @foreach(['Obat','Alkes','Matkes','Umum','ATK'] as $j)
                <option value="{{ $j }}" @selected($jenis == $j)>{{ $j }}</option>
            @endforeach
        </select>
    </div>

    {{-- FOTO --}}
    <div class="form-group">
        <label>Foto Item</label>
        <input type="file" class="form-control" name="foto">
        @if(!empty($item->foto))
            <img src="{{ asset('uploads/items/'.$item->foto) }}" width="120" class="mt-2">
        @endif
    </div>

    {{-- KATEGORI --}}
    <div class="form-group">
        <label>Kategori</label>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    @if(isset($item) && $item->categories->pluck('id')->contains($cat->id)) selected @endif>
                    {{ $cat->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>
