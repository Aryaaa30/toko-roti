
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
    }

    .card img {
    width: 100%;
    aspect-ratio: 3 / 4;
    object-fit: cover;
    display: block;
    flex: 0 0 auto;
    width: 260px;
    scroll-snap-align: start;
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
    <h1>Daftar Produk Roti</h1>

    @if(auth()->user()->is_admin)
        <a href="{{ route('menus.create') }}" class="btn-add">Tambah Produk</a>
    @endif
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div class="product-grid">
    @foreach($menus as $menu)
    <div class="card">
        @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
        @else
            <img src="https://via.placeholder.com/300x180?text=No+Image" alt="No image">
        @endif

        <div class="card-body">
            <div class="card-title">{{ $menu->name }}</div>
            <div class="card-text">{{ $menu->description }}</div>
            <div class="card-price">Rp {{ number_format($menu->price,0,',','.') }}</div>

            <div class="btn-group">
                @if(auth()->user()->is_admin)
                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn-sm btn-warning">Edit</a>

                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus produk?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger">Hapus</button>
                    </form>
                @else
                    <!-- Contoh tombol untuk user biasa, misal tambah ke keranjang -->
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <button type="submit" class="btn-sm btn-warning">Tambah ke Keranjang</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>