<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok - InventOx</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN STOK BARANG</h2>
        <p>InventOx - {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Minimal Stok</th>
                <th>Satuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->nama_barang }}</td>
                <td>{{ $product->category->nama_category ?? '-' }}</td>
                <td>{{ $product->stok }}</td>
                <td>{{ $product->minimal_stok }}</td>
                <td>{{ $product->satuan }}</td>
                <td>
                    @if($product->stok == 0)
                        <span style="color: red;">Habis</span>
                    @elseif($product->stok <= $product->minimal_stok)
                        <span style="color: orange;">Menipis</span>
                    @else
                        Aman
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>