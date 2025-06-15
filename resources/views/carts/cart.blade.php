@extends('layouts.app')

@section('content')
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

    .card-img {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-img img {
        width: 100%;
        height: 100%;
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
        margin-bottom: 4px;
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

    .quantity-control {
        display: flex;
        align-items: center;
        border: 1px solid #c4c9d9;
        border-radius: 4px;
        overflow: hidden;
        width: 90px;
        height: 30px;
    }

    .quantity-control button {
        border: none;
        background: none;
        font-size: 16px;
        color: #e67e22;
        font-weight: 700;
        width: 28px;
        height: 30px;
        cursor: pointer;
        user-select: none;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .quantity-control button:disabled {
        color: #ccc;
        cursor: default;
    }

    .quantity-control input {
        width: 34px;
        height: 30px;
        border: none;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #222;
        outline: none;
        user-select: none;
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
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
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
        max-width: 1200px;
        margin: 0 auto 15px;
    }

    .empty-message {
        text-align: center;
        padding: 50px 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 30px auto;
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
    
    .header-area {
        text-align: center;
        padding: 30px 0 10px;
    }
    
    .header-area h1 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
    }
    
    .badge-status {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .badge-available {
        background-color: #2ecc71;
        color: white;
    }

    .badge-unavailable {
        background-color: #e74c3c;
        color: white;
    }
    
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }
        
        .right-column {
            position: static;
        }
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

            <div class="card-img">
                @if($cart->menu && $cart->menu->images)
                    @php
                        $images = json_decode($cart->menu->images);
                        $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                    @endphp
                    @if($firstImage)
                        <img src="{{ asset('storage/'.$firstImage) }}" alt="{{ $cart->menu->name }}">
                    @else
                        <img src="https://via.placeholder.com/100" alt="No image">
                    @endif
                @elseif($cart->menu && $cart->menu->image)
                    <img src="{{ asset('storage/'.$cart->menu->image) }}" alt="{{ $cart->menu->name }}">
                @else
                    <img src="https://via.placeholder.com/100" alt="No image">
                @endif
            </div>

            <div class="card-body">
                <div class="card-title">{{ $cart->menu->name ?? 'Produk tidak ditemukan' }}</div>
                
                @if($cart->menu && isset($cart->menu->available))
                    <span class="badge-status {{ $cart->menu->available ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $cart->menu->available ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                @endif
                
                <div class="card-text"><strong>Kategori:</strong> {{ $cart->menu->kategori ?? '-' }}</div>
                <div class="card-text">{{ Str::limit($cart->menu->description ?? '-', 100) }}</div>
                <div class="card-text"><strong>Stok:</strong> {{ $cart->menu->stok ?? 0 }} pcs</div>
                <div class="card-price">Rp {{ number_format($cart->menu->price ?? 0, 0, ',', '.') }}</div>

                <div class="quantity-form">
                    <div class="quantity-control">
                        <button type="button" class="decrease-btn" onclick="updateQuantity(this, -1)">-</button>
                        <input type="text" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->menu->stok ?? 1 }}" class="quantity-input" data-price="{{ $cart->menu->price ?? 0 }}" readonly>
                        <button type="button" class="increase-btn" onclick="updateQuantity(this, 1)">+</button>
                    </div>
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
        <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
            @csrf
            <input type="hidden" name="selected_items" id="selected-items" value="">
            <button type="submit" class="btn-checkout" id="checkout-btn">Checkout</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize quantity buttons state
        document.querySelectorAll('.quantity-control').forEach(control => {
            const input = control.querySelector('.quantity-input');
            const decreaseBtn = control.querySelector('.decrease-btn');
            const increaseBtn = control.querySelector('.increase-btn');
            const currentQty = parseInt(input.value);
            const maxQty = parseInt(input.getAttribute('max'));
            
            decreaseBtn.disabled = currentQty <= 1;
            increaseBtn.disabled = currentQty >= maxQty;
        });
        
        // Secara default pilih semua checkbox
        document.getElementById('select-all').checked = true;
        document.querySelectorAll('.product-checkbox').forEach(cb => {
            cb.checked = true;
        });
        
        // Update total on page load
        updateTotal();
    });

    function updateQuantity(button, change) {
        const control = button.closest('.quantity-control');
        const input = control.querySelector('.quantity-input');
        const decreaseBtn = control.querySelector('.decrease-btn');
        const increaseBtn = control.querySelector('.increase-btn');
        
        let currentQty = parseInt(input.value);
        const maxQty = parseInt(input.getAttribute('max'));
        const price = parseInt(input.dataset.price);
        
        let newQty = currentQty + change;
        if (newQty < 1) newQty = 1;
        if (newQty > maxQty) newQty = maxQty;
        
        input.value = newQty;
        
        // Update buttons state
        decreaseBtn.disabled = newQty <= 1;
        increaseBtn.disabled = newQty >= maxQty;
        
        // Update item total
        const card = button.closest('.card');
        const cartId = card.dataset.id;
        const checkbox = card.querySelector('.product-checkbox');
        
        // Update via AJAX
        fetch(`/carts/${cartId}/quantity`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => res.json())
        .then(data => {
            const totalPerItem = data.total;
            const totalElement = card.querySelector('.total-price');
            checkbox.dataset.total = totalPerItem;
            totalElement.textContent = totalPerItem.toLocaleString('id-ID');
            updateTotal();
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
        });
    }

    function updateTotal() {
        let total = 0;
        const selectedItems = [];
        
        document.querySelectorAll('.product-checkbox:checked').forEach(cb => {
            const cartId = cb.closest('.card').dataset.id;
            total += parseInt(cb.dataset.total || 0);
            selectedItems.push(cartId);
        });
        
        document.getElementById('total-amount').textContent = total.toLocaleString('id-ID');
        document.getElementById('selected-items').value = selectedItems.join(',');
        
        // Disable checkout button if no items selected
        document.getElementById('checkout-btn').disabled = selectedItems.length === 0;
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
    
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const selectedItems = document.getElementById('selected-items').value;
        if (!selectedItems) {
            e.preventDefault();
            alert('Silakan pilih produk yang ingin dibeli terlebih dahulu.');
        }
    });
</script>
@endsection