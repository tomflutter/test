<h3>Master Item</h3>

<p><strong>Kode Item:</strong> {{ $item->kode }}</p>
<p><strong>Nama:</strong> {{ $item->nama }}</p>
<p><strong>Supplier:</strong> {{ $item->supplier }}</p>
<p><strong>Jenis:</strong> {{ $item->jenis }}</p>
<p><strong>Harga Beli:</strong> {{ number_format($item->harga_beli) }}</p>
<p><strong>Laba:</strong> {{ $item->laba }}%</p>
<p><strong>Harga Jual:</strong>
    {{ number_format($item->harga_beli + ($item->harga_beli * $item->laba / 100)) }}
</p>

<hr>

<h4>Kategori</h4>

@if($item->categories->isEmpty())
    <p>-</p>
@else
    <ul>
        @foreach($item->categories as $cat)
            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
        @endforeach
    </ul>
@endif

<hr>

<footer>
    <small>
        Dicetak: {{ now()->format('d-m-Y H:i:s') }}
    </small>
</footer>
