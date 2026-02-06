<h3 style="text-align:center">MASTER ITEM</h3>

<table width="100%" cellpadding="5">
    <tr>
        <td width="30%">Kode Item</td>
        <td>: {{ $item->kode }}</td>
    </tr>
    <tr>
        <td>Nama Item</td>
        <td>: {{ $item->nama }}</td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td>: {{ $item->supplier }}</td>
    </tr>
    <tr>
        <td>Jenis</td>
        <td>: {{ $item->jenis }}</td>
    </tr>
    <tr>
        <td>Harga Beli</td>
        <td>: {{ number_format($item->harga_beli) }}</td>
    </tr>
    <tr>
        <td>Laba</td>
        <td>: {{ $item->laba }}%</td>
    </tr>
    <tr>
        <td>Harga Jual</td>
        <td>: {{ number_format($item->harga_beli + ($item->harga_beli * $item->laba / 100)) }}</td>
    </tr>
</table>

<hr>

<strong>Kategori:</strong>
@if($item->categories->isEmpty())
    -
@else
    <ul>
        @foreach($item->categories as $cat)
            <li>{{ $cat->nama }} ({{ $cat->kode }})</li>
        @endforeach
    </ul>
@endif

<hr>

<small>
    Dicetak: {{ now()->format('d-m-Y H:i:s') }}
</small>
