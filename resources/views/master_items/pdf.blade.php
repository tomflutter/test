<h3>Master Item: {{ $item->nama }}</h3>

<p>Supplier: {{ $item->supplier }}</p>
<p>Jenis: {{ $item->jenis }}</p>
<p>Harga Beli: {{ $item->harga_beli }}</p>
<p>Laba: {{ $item->laba }}%</p>
<p>Harga Jual: {{ $item->harga_beli + ($item->harga_beli * $item->laba / 100) }}</p>

<h4>Kategori:</h4>

@if($item->categories->isEmpty())
    <p>-</p>
@else
    <ul>
        @foreach($item->categories as $cat)
            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
        @endforeach
    </ul>
@endif

<footer>
    <p>Dicetak: {{ now()->format('d-m-Y H:i:s') }}</p>
</footer>
