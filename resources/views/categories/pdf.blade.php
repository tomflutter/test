<!DOCTYPE html>
<html>
<head>
    <title>Kategori {{ $category->nama }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; padding: 5px; }
        th { background: #eee; }
        footer { position: fixed; bottom: 0; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <h3>Kategori: {{ $category->nama }} ({{ $category->kode }})</h3>
    <table>
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
            @foreach($category->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ $item->harga_beli }}</td>
                <td>{{ $item->laba }}</td>
                <td>{{ $item->harga_beli + ($item->harga_beli * $item->laba / 100) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>Dicetak pada: {{ date('d-m-Y H:i:s') }}</footer>
</body>
</html>
