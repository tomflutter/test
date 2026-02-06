<h3>Master Item: {{ $data->nama }}</h3>
<p>Supplier: {{ $data->supplier }}</p>
<p>Jenis: {{ $data->jenis }}</p>
<p>Harga Beli: {{ $data->harga_beli }}</p>
<p>Laba: {{ $data->laba }}%</p>
<p>Harga Jual: {{ $data->harga_beli + ($data->harga_beli * $data->laba / 100) }}</p>

<h4>Kategori:</h4>
@if($data->categories->isEmpty())
    <p>-</p>
@else
    <ul>
        @foreach($data->categories as $cat)
            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
        @endforeach
    </ul>
@endif

<footer>
    <p>Dicetak: {{ now()->format('d-m-Y H:i:s') }}</p>
</footer>
