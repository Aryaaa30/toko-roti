<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        display: flex;
        gap: 20px;
        max-width: 1200px;
        margin: 30px auto;
    }

    .left-column {
        flex: 2;
    }

    .right-column {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 30px;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        display: flex;
        gap: 15px;
        position: relative;
        padding: 10px;
    }

    .card img {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
    }

    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
        color: #2c3e50;
    }

    .card-text {
        font-size: 14px;
        color: #7f8c8d;
    }

    .card-price {
        font-weight: bold;
        color: #e67e22;
        margin-top: 8px;
    }

    .quantity-form {
        display: flex;
        align-items: center;
        margin-top: 8px;
    }

    .quantity-form input[type="number"] {
        width: 50px;
        padding: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
    }

    .btn-sm {
        background-color: #e74c3c;
        color: #fff;
        border: none;
        padding: 4px 8px;
        border-radius: 4px;
        margin-top: 8px;
        cursor: pointer;
    }

    .select-all-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .total-display {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .btn-checkout {
        width: 100%;
        background-color: #27ae60;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
    }

    .alert {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .empty-message {
        text-align: center;
        padding: 50px 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background-color: #e67e22;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #d35400;
    }

    .card input[type="checkbox"] {
        position: absolute;
        top: 10px;
        left: 10px;
    }
</style>

<div class="header-area">
    <h1>Keranjang Belanja</h1>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

@if($carts->count() > 0)
<div class="container">
    <div class="left-column">
        <div class="select-all-wrapper">
            <input type="checkbox" id="select-all"> <label for="select-all">Pilih Semua</label>
        </div>

        @foreach($carts as $cart)
        <div class="card" data-id="{{ $cart->id }}">
            <input type="checkbox" class="product-checkbox" data-total="{{ ($cart->menu->price ?? 0) * $cart->quantity }}">

            @if($cart->menu && $cart->menu->image)
                <img src="{{ asset('storage/'.$cart->menu->image) }}" alt="{{ $cart->menu->name }}">
            @else
                <img src="https://via.placeholder.com/100" alt="No image">
            @endif

            <div class="card-body">
                <div class="card-title">{{ $cart->menu->name ?? 'Produk tidak ditemukan' }}</div>
                <div class="card-text"><strong>Kategori:</strong> {{ $cart->menu->kategori ?? '-' }}</div>
                <div class="card-text">{{ $cart->menu->description ?? '-' }}</div>
                <div class="card-text"><strong>Stok:</strong> {{ $cart->menu->stok ?? 0 }} pcs</div>
                <div class="card-price">Rp {{ number_format($cart->menu->price ?? 0, 0, ',', '.') }}</div>

                <div class="quantity-form">
                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" class="quantity-input" data-price="{{ $cart->menu->price ?? 0 }}">
                </div>

                <div class="card-price">
                    Total: Rp <span class="total-price">{{ number_format(($cart->menu->price ?? 0) * $cart->quantity, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="right-column">
        <div class="total-display">Total: Rp <span id="total-amount">0</span></div>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn-checkout">Beli</button>
        </form>
    </div>
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
