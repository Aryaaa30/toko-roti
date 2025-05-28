
<meta name="csrf-token" content="{{ csrf_token() }}">

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
        text-decoration: none;
        color: inherit;
    }

    .card img {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        display: block;
        flex: 0 0 auto;
        transition: transform 0.3s;
    }

    .card:hover img {
        transform: scale(1.05);
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
        margin-bottom: 8px;
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

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
    }

    #snackbar {
        visibility: hidden;
        min-width: 250px;
        background-color: #27ae60;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 12px;
        position: fixed;
        z-index: 999;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
        font-size: 16px;
    }

    #snackbar.show {
        visibility: visible;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @keyframes fadein {
        from { bottom: 0; opacity: 0; }
        to { bottom: 30px; opacity: 1; }
    }

    @keyframes fadeout {
        from { bottom: 30px; opacity: 1; }
        to { bottom: 0; opacity: 0; }
    }
</style>

<div class="header-area">
    <h1>Menu Roti Tersedia</h1>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div id="snackbar">Berhasil ditambahkan ke keranjang!</div>

<div class="product-grid">
    @foreach($menus as $menu)
        <div class="card">
            <a href="{{ route('menus.show', $menu->id) }}" style="text-decoration: none; color: inherit;">
                @if($menu->image)
                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
                @else
                    <img src="https://via.placeholder.com/300x180?text=No+Image" alt="No image">
                @endif
                <div class="card-body">
                    <div class="card-title">{{ $menu->name }}</div>
                    <div class="card-text"><strong>Kategori:</strong> {{ $menu->kategori ?? 'Tidak ada' }}</div>
                    <div class="card-text">{{ $menu->description }}</div>
                    <div class="card-text"><strong>Stok:</strong> {{ $menu->stok }} pcs</div>
                    <div class="card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                </div>
            </a>

            <div class="btn-group" style="padding: 0 16px 16px;">
                <button class="btn-sm btn-warning"
                    onclick="addToCart({{ $menu->id }}, {{ $menu->stok <= 0 ? 'true' : 'false' }})"
                    @if($menu->stok <= 0) disabled style="cursor: not-allowed; opacity: 0.6;" @endif>
                    Tambah ke Keranjang
                </button>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-sm btn-warning"
                        @if($menu->stok <= 0) disabled style="cursor: not-allowed; opacity: 0.6;" @endif>
                        Beli
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<script>
    function addToCart(menuId, disabled) {
        if (disabled) return;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('carts.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                menu_id: menuId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal menambahkan ke keranjang');
            }
            return response.json();
        })
        .then(data => {
            showSnackbar(data.message || "Berhasil ditambahkan ke keranjang!");
        })
        .catch(error => {
            console.error(error);
            showSnackbar("Gagal menambahkan ke keranjang!", true);
        });
    }

    function showSnackbar(message, isError = false) {
        const snackbar = document.getElementById("snackbar");
        snackbar.textContent = message;
        snackbar.style.backgroundColor = isError ? "#e74c3c" : "#27ae60";
        snackbar.classList.add("show");

        setTimeout(() => {
            snackbar.classList.remove("show");
        }, 3000);
    }
</script>

