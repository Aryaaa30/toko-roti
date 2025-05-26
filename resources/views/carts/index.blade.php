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

    .quantity-form {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .quantity-form input[type="number"] {
        width: 60px;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-right: 8px;
        font-size: 14px;
    }

    .checkout-wrapper {
        text-align: center;
        margin-top: 30px;
    }

    .btn-checkout {
        background-color: #27ae60;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-checkout:hover {
        background-color: #219150;
    }

    .empty-message {
        text-align: center;
        margin-top: 40px;
        font-size: 18px;
        color: #7f8c8d;
    }

    .btn-primary {
        background-color: #e67e22;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #d35400;
    }
</style>

<div class="header-area">
    <h1>Keranjang Belanja</h1>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

@if($carts->count() > 0)
    <div class="product-grid">
        @foreach($carts as $cart)
        <div class="card">
            @if($cart->menu && $cart->menu->image)
                <img src="{{ asset('storage/'.$cart->menu->image) }}" alt="{{ $cart->menu->name }}">
            @else
                <img src="https://via.placeholder.com/300x180?text=No+Image" alt="No image">
            @endif

            <div class="card-body">
                <div class="card-title">{{ $cart->menu->name ?? 'Produk tidak ditemukan' }}</div>
                <div class="card-text">{{ $cart->menu->description ?? '-' }}</div>
                <div class="card-price">Rp {{ number_format($cart->menu->price ?? 0, 0, ',', '.') }}</div>

                <form action="{{ route('carts.update', $cart->id) }}" method="POST" class="quantity-form">
                    @csrf
                    @method('PUT')
                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" aria-label="Jumlah produk">
                    <button type="submit" class="btn-sm btn-warning">Update</button>
                </form>

                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger" style="width: 100%;">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('orders.store') }}" method="POST" class="checkout-wrapper" style="text-align:center; margin-top: 30px;">
    @csrf
    <button type="submit" class="btn-checkout">Checkout</button>
</form>
@else
    <div class="empty-message">
        <p>Keranjang belanja kosong.</p>
        <a href="{{ route('menus.index') }}" class="btn-primary">Belanja Sekarang</a>
    </div>
@endif
