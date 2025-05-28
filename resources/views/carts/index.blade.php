
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
        position: relative;
    }

    .card input[type="checkbox"] {
        position: absolute;
        top: 10px;
        left: 10px;
        transform: scale(1.4);
    }

    .card img {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        display: block;
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
        flex: 1;
    }

    .card-price {
        font-weight: bold;
        font-size: 16px;
        color: #e67e22;
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

    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .checkout-wrapper {
        text-align: center;
        margin: 30px auto;
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
        margin-left: 20px;
    }

    .btn-checkout:hover {
        background-color: #219150;
    }

    .total-display {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
        display: inline-block;
    }

    .select-all-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
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

    <div class="select-all-wrapper">
        <input type="checkbox" id="select-all"> <label for="select-all">Pilih Semua</label>
    </div>

    <div class="product-grid">
        @foreach($carts as $cart)
        <div class="card" data-id="{{ $cart->id }}">
            <input 
                type="checkbox" 
                class="product-checkbox"
                data-total="{{ ($cart->menu->price ?? 0) * $cart->quantity }}"
            >

            @if($cart->menu && $cart->menu->image)
                <img src="{{ asset('storage/'.$cart->menu->image) }}" alt="{{ $cart->menu->name }}">
            @else
                <img src="https://via.placeholder.com/300x180?text=No+Image" alt="No image">
            @endif

            <div class="card-body">
                <div class="card-title">{{ $cart->menu->name ?? 'Produk tidak ditemukan' }}</div>
                <div class="card-text"><strong>Kategori:</strong> {{ $cart->menu->kategori ?? '-' }}</div>
                <div class="card-text">{{ $cart->menu->description ?? '-' }}</div>
                <div class="card-text"><strong>Stok:</strong> {{ $cart->menu->stok ?? 0 }} pcs</div>
                <div class="card-price">Harga: Rp {{ number_format($cart->menu->price ?? 0, 0, ',', '.') }}</div>

                <div class="quantity-form">
                    <input 
                        type="number" 
                        name="quantity" 
                        value="{{ $cart->quantity }}" 
                        min="1" 
                        class="quantity-input"
                        data-price="{{ $cart->menu->price ?? 0 }}"
                        aria-label="Jumlah produk"
                    >
                </div>

                <div class="card-price">
                    Total: Rp <span class="total-price">
                        {{ number_format(($cart->menu->price ?? 0) * $cart->quantity, 0, ',', '.') }}
                    </span>
                </div>

                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger" style="width: 100%;">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="checkout-wrapper">
        <span class="total-display">Total: Rp <span id="total-amount">0</span></span>
        <form action="{{ route('orders.store') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-checkout">Checkout</button>
        </form>
    </div>

@else
    <div class="empty-message">
        <p>Keranjang belanja kosong.</p>
        <a href="{{ route('menus.index') }}" class="btn-primary">Belanja Sekarang</a>
    </div>
@endif

<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.product-checkbox:checked').forEach(cb => {
            total += parseInt(cb.dataset.total || 0);
        });
        document.getElementById('total-amount').textContent = total.toLocaleString('id-ID');
    }

    document.querySelectorAll('.product-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    document.getElementById('select-all').addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.checked = checked;
        });
        updateTotal();
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function () {
            const card = this.closest('.card');
            const cartId = card.dataset.id;
            const price = parseInt(this.dataset.price);
            const quantity = parseInt(this.value);

            fetch(`/carts/${cartId}/quantity`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity })
            })
            .then(res => res.json())
            .then(data => {
                const totalPerItem = data.total;
                const totalElement = card.querySelector('.total-price');
                const checkbox = card.querySelector('.product-checkbox');
                checkbox.dataset.total = totalPerItem;
                totalElement.textContent = totalPerItem.toLocaleString('id-ID');
                updateTotal();
            });
        });
    });
</script>

