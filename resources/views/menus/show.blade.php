<style>
    .product-detail {
        max-width: 800px;
        margin: 40px auto;
        padding: 24px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }

    .product-image {
        flex: 1 1 300px;
        max-width: 300px;
    }

    .product-image img {
        width: 100%;
        border-radius: 12px;
        object-fit: cover;
    }

    .product-info {
        flex: 2 1 400px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .product-info h2 {
        font-size: 28px;
        color: #2c3e50;
        margin: 0;
    }

    .product-info p {
        font-size: 16px;
        color: #7f8c8d;
    }

    .product-price {
        font-size: 22px;
        color: #e67e22;
        font-weight: bold;
    }

    .product-stock {
        font-size: 14px;
        font-weight: bold;
        color: #27ae60;
    }

    .btn-group {
        display: flex;
        gap: 16px;
        margin-top: 20px;
    }

    .btn-sm {
        font-size: 16px;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-warning {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }

    .snackbar {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #2ecc71;
        color: white;
        padding: 14px 24px;
        border-radius: 8px;
        font-size: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        display: none;
        z-index: 1000;
    }
</style>

<div class="product-detail">
    <div class="product-image">
        @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
        @else
            <img src="https://via.placeholder.com/300x300?text=No+Image" alt="No image">
        @endif
    </div>

    <div class="product-info">
        <h2>{{ $menu->name }}</h2>

        <p><strong>Kategori:</strong> {{ $menu->kategori ?? 'Tidak ada' }}</p>

        <p>{{ $menu->description }}</p>

        <div class="product-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>

        <div class="product-stock">Stok: {{ $menu->stok }} pcs</div>

        <div class="btn-group">
            <button
                class="btn-sm btn-warning"
                onclick="addToCart({{ $menu->id }})"
                @if($menu->stok <= 0) disabled style="cursor: not-allowed; opacity: 0.6;" @endif
            >
                Tambah ke Keranjang
            </button>

            <form action="#" method="POST">
                @csrf
                {{-- Buatkan route untuk beli langsung jika ada --}}
                <button type="button" class="btn-sm btn-danger" disabled>🛒 Beli Sekarang</button>
            </form>
        </div>
    </div>
</div>

<div id="snackbar" class="snackbar">Item berhasil ditambahkan ke keranjang!</div>

<script>
    function addToCart(menuId) {
        fetch("{{ route('carts.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                menu_id: menuId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSnackbar(data.message || "Berhasil menambahkan ke keranjang.");
            } else {
                alert("Gagal menambahkan ke keranjang.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan.");
        });
    }

    function showSnackbar(message) {
        const snackbar = document.getElementById("snackbar");
        snackbar.textContent = message;
        snackbar.style.display = "block";
        setTimeout(() => {
            snackbar.style.display = "none";
        }, 3000);
    }
</script>
