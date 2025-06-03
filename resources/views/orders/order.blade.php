<style>
    body {
        background-color: #ffffff;
        font-family: 'Segoe UI', sans-serif;
    }

    .header-area {
        text-align: center;
        padding: 40px 20px 20px;
    }

    .header-area h1 {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
    }

    .btn-add {
        background-color: #e67e22;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-add:hover {
        background-color: #d35400;
    }

    .product-grid {
        display: flex;
        overflow-x: auto;
        gap: 24px;
        padding: 30px;
        scroll-snap-type: x mandatory;
    }

    .card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        width: 260px;
        scroll-snap-align: start;
    }

    .card img {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        display: block;
        flex: 0 0 auto;
    }

    .product-grid::-webkit-scrollbar {
        height: 10px;
    }
    .product-grid::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 10px;
    }

    .card-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .card-text {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 12px;
        flex: 1;
    }

    .card-price {
        font-weight: bold;
        font-size: 16px;
        color: #e67e22;
        margin-bottom: 12px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }

    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-warning {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
    }
</style>

<div class="header-area">
    <h1>Daftar Pesanan</h1>

    @if(auth()->user()->is_admin)
        <a href="{{ route('menus.create') }}" class="btn-add">Tambah Produk</a>
    @endif
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

@if($orders->count() > 0)
    <div class="product-grid">
        @foreach($orders as $order)
        <div class="card">
            {{-- Gambar produk utama dari order item pertama (jika ada) --}}
            @php
                $firstItem = $order->items->first();
                $image = $firstItem && $firstItem->menu && $firstItem->menu->image ? $firstItem->menu->image : null;
            @endphp

            @if($image)
                <img src="{{ asset('storage/'.$image) }}" alt="Gambar Pesanan {{ $order->order_code }}">
            @else
                <img src="https://via.placeholder.com/300x180?text=No+Image" alt="No image">
            @endif

            <div class="card-body">
                <div class="card-title">Kode: {{ $order->order_code }}</div>
                @if(auth()->user()->is_admin)
                    <div class="card-text">Pemesan: {{ $order->user->name ?? '-' }}</div>
                @endif
                <div class="card-text">Total Harga: Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                <div class="card-text">
                    Status: 
                    @switch($order->status)
                        @case('pending')
                            <span style="color:#f1c40f;font-weight:bold;">Pending</span>
                            @break
                        @case('processing')
                            <span style="color:#3498db;font-weight:bold;">Processing</span>
                            @break
                        @case('completed')
                            <span style="color:#2ecc71;font-weight:bold;">Completed</span>
                            @break
                        @case('cancelled')
                            <span style="color:#e74c3c;font-weight:bold;">Cancelled</span>
                            @break
                        @default
                            <span>{{ ucfirst($order->status) }}</span>
                    @endswitch
                </div>
                <div class="card-text">
                    Pembayaran: 
                    @switch($order->payment_status)
                        @case('unpaid')
                            <span style="color:#e74c3c;font-weight:bold;">Unpaid</span>
                            @break
                        @case('paid')
                            <span style="color:#2ecc71;font-weight:bold;">Paid</span>
                            @break
                        @default
                            <span>{{ ucfirst($order->payment_status) }}</span>
                    @endswitch
                </div>

                <div class="btn-group">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-sm btn-warning">Detail</a>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn-sm btn-warning">Edit</a>

                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <p style="text-align:center; margin-top: 40px;">Belum ada pesanan.</p>
    <div style="text-align:center;">
        <a href="{{ route('menus.index') }}" class="btn-add">Mulai Belanja</a>
    </div>
@endif
