
<div class="container">
    <h1>Daftar Item Pesanan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orderItems->count() > 0)
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                <tr>
                    <td>{{ $item->order->order_code ?? '-' }}</td>
                    <td>{{ $item->menu->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('orderitems.edit', $item->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>

                        <form action="{{ route('orderitems.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-1">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada item pesanan.</p>
        <a href="{{ route('orders.index') }}" class="btn btn-primary">Kembali ke Pesanan</a>
    @endif
</div>
