@extends('layouts.app')

@section('content')
@php
    // Cari alamat yang paling sering digunakan di cart items
    $cartAddresses = $carts->pluck('address')->filter();
    $mostUsedAddress = $cartAddresses->count() > 0 ? $cartAddresses->first() : null;
    $displayAddress = $mostUsedAddress ?? $defaultAddress;
@endphp

<style>
    /* Leaflet CSS Override for dark theme */
    .leaflet-container {
        background: #111 !important;
    }
    
    .leaflet-control-attribution {
        background: rgba(0,0,0,0.8) !important;
        color: #888 !important;
    }
    
    .leaflet-control-attribution a {
        color: #fec6e4 !important;
    }

    /* General Styles with Dark Mode Palette */
    body {
        --bg-dark: rgb(10, 10, 10);
        --card-bg: rgb(18, 18, 18);
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #b0b0b0;
        --text-white: #ffffff;

        background-color: black;
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: var(--text-base);
    }

    .cart-container {
        max-width: 1220px;
        margin: 40px auto;
        padding: 25px;
        background-color: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    /* Cart Header */
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .cart-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        color: var(--text-base);
    }

    .cart-header .continue-shopping {
        text-decoration: none;
        color: var(--text-secondary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s;
    }
    .cart-header .continue-shopping:hover {
        color: var(--text-base);
    }

    /* Cart Table */
    .cart-table-header {
        display: grid;
        grid-template-columns: 3fr 2fr 1fr 1fr 0.5fr;
        gap: 20px;
        padding: 0 15px;
        margin-bottom: 10px;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    /* Cart Item */
    .cart-item {
        display: grid;
        grid-template-columns: 3fr 2fr 1fr 1fr 0.5fr;
        gap: 20px;
        align-items: center;
        padding: 20px 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .item-product {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .item-product img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }

    .product-details .product-name {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
        color: var(--text-base);
    }

    .product-details .product-info {
        font-size: 12px;
        color: var(--text-secondary);
    }

    .item-price .base-price {
        font-weight: 700;
        font-size: 16px;
        color: var(--text-base);
    }

    .item-price .extra-info {
        font-size: 12px;
        color: var(--text-secondary);
    }
    
    .item-qty {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        width: 100px;
    }

    .item-qty button {
        border: none;
        background: none;
        font-size: 18px;
        font-weight: 600;
        color: var(--text-base);
        cursor: pointer;
        padding: 8px 12px;
    }
    
    .item-qty button:disabled {
        color: #555;
    }

    .item-qty .quantity-input {
        width: 30px;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        background: transparent;
        outline: none;
        color: var(--text-base);
    }
    
    .item-total {
        font-weight: 700;
        font-size: 16px;
        text-align: right;
        color: var(--text-important);
    }

    .item-remove button {
        border: none;
        background: none;
        font-size: 20px;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 5px;
        line-height: 1;
    }
    .item-remove button:hover {
        color: #e74c3c;
    }
    
    /* Cart Footer */
    .cart-footer {
        margin-top: 30px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    .shipping-mode h3 {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .shipping-option {
        padding: 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .shipping-option input[type="radio"] {
       accent-color: var(--text-important);
       transform: scale(1.3);
       background-color: var(--bg-dark); /* For non-supporting browsers */
       pointer-events: none; /* The whole div is not clickable, so no need for pointer */
    }
    
    .shipping-option.selected {
        border-color: var(--text-important);
        background-color: rgba(254, 198, 228, 0.07);
    }

    .shipping-info .label {
        font-weight: 600;
        color: var(--text-base);
    }
    
    .shipping-info .description {
        font-size: 13px;
        color: var(--text-secondary);
    }
    
    .shipping-cost {
        margin-left: auto;
        font-weight: 700;
        color: var(--text-base);
    }

    .summary {
        background-color: var(--bg-dark);
        padding: 25px;
        border-radius: 8px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 16px;
        color: var(--text-secondary);
    }
    .summary-item span:last-child {
        color: var(--text-base);
        font-weight: 600;
    }
    
    .summary-item.total {
        color: var(--text-base);
        font-weight: 700;
        font-size: 18px;
        border-top: 1px solid var(--border-color);
        padding-top: 15px;
        margin-top: 10px;
    }
    .summary-item.total span:last-child {
        color: var(--text-important);
    }
    
    .btn-checkout {
        width: 100%;
        background-color: var(--text-important);
        color: var(--bg-dark);
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.2s;
    }
    
    .btn-checkout:hover {
        background-color: rgb(255, 215, 235);
    }

    .btn-checkout:disabled {
        background-color: #444;
        color: #888;
        cursor: not-allowed;
    }

    .empty-message {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-message p {
        font-size: 18px;
        color: var(--text-secondary);
        margin-bottom: 20px;
    }
    
    .btn-primary {
        background-color: var(--text-important);
        color: var(--bg-dark);
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: rgb(255, 215, 235);
    }
</style>

<div class="cart-container">
    @if($carts->count() > 0)
        <div class="cart-header">
            <h1>My Cart</h1>
            <a href="{{ route('menus.index') }}" class="continue-shopping">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Continue shopping
            </a>
        </div>

        <div class="cart-table-header">
            <div>Product</div>
            <div>Price</div>
            <div style="text-align:center;">Qty</div>
            <div style="text-align:right;">Total</div>
            <div></div>
        </div>

        <div id="cart-items-wrapper">
            @foreach($carts as $cart)
            <div class="cart-item" data-id="{{ $cart->id }}" data-price="{{ $cart->menu->price ?? 0 }}" data-stock="{{ $cart->menu->stok ?? 1 }}">
                <div class="item-product">
                    @php
                        $img = null;
                        if ($cart->menu && $cart->menu->images) {
                            $imgs = json_decode($cart->menu->images, true);
                            if (is_array($imgs) && count($imgs) > 0) {
                                $img = asset('storage/' . $imgs[0]);
                            }
                        }
                        if (!$img && $cart->menu && $cart->menu->image) {
                            $img = asset('storage/' . $cart->menu->image);
                        }
                    @endphp
                    <img src="{{ $img ?? 'https://via.placeholder.com/80' }}" alt="{{ $cart->menu->name }}">
                    <div class="product-details">
                        <div class="product-name">{{ $cart->menu->name ?? 'Produk tidak ditemukan' }}</div>
                        <div class="product-info">Kategori: {{ $cart->menu->kategori ?? '-' }}</div>
                        @if($cart->notes)
                          <div class="product-info" style="color:#fec6e4; font-size:13px; margin-top:2px;">Catatan: {{ $cart->notes }}</div>
                        @endif
                    </div>
                </div>
                <div class="item-price">
                    <div class="base-price">Rp {{ number_format($cart->menu->price ?? 0, 0, ',', '.') }}</div>
                    <div class="extra-info">Harga per item</div>
                </div>
                <div class="item-qty">
                    <button type="button" class="decrease-btn" onclick="updateQuantity(this, -1)">-</button>
                    <input type="text" value="{{ $cart->quantity }}" class="quantity-input" readonly>
                    <button type="button" class="increase-btn" onclick="updateQuantity(this, 1)">+</button>
                </div>
                <div class="item-total">
                    Rp <span class="line-total-price">{{ number_format(($cart->menu->price ?? 0) * $cart->quantity, 0, ',', '.') }}</span>
                </div>
                <div class="item-remove">
                    <form action="{{ route('carts.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">&times;</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cart-footer">
            <div class="shipping-mode">
                <h3>Shipping Method</h3>
                <div class="shipping-option selected">
                    <input type="radio" id="shipping-delivery" name="shipping" value="0" data-cost="0" checked>
                    <div class="shipping-info">
                        <div class="label">Delivery at home</div>
                        @if(isset($addresses) && count($addresses) > 0)
                          <label for="address-select" style="font-size:14px; color:#fec6e4; font-weight:600; margin-top:8px; display:block;">Pilih Alamat Pengiriman:</label>
                          <div class="description" id="address-detail-box" style="cursor:pointer; position:relative;"></div>
                          <div id="address-dropdown-list" style="display:none; position:absolute; z-index:10; background:#222; border:1px solid #fec6e4; border-radius:6px; min-width:260px; max-width:400px; box-shadow:0 2px 8px #0008;"></div>
                        @else
                          <div style="color: #ef4444; font-size: 14px; margin-bottom: 8px;">Anda belum memiliki alamat pengiriman.</div>
                        @endif
                    </div>
                    <div class="shipping-cost">FREE</div>
                </div>
            </div>

            <div class="summary">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span id="summary-subtotal">Rp 0</span>
                </div>
                <div class="summary-item">
                    <span>Shipping</span>
                    <span id="summary-shipping">Rp 0</span>
                </div>
                <div class="summary-item total">
                    <span>TOTAL</span>
                    <span id="summary-total">Rp 0</span>
                </div>
                
                <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items" value="">
                    <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="0">
                    <button type="submit" class="btn-checkout" id="checkout-btn">
                        <span>Checkout!</span>
                        <span id="checkout-total">Rp 0</span>
                    </button>
                </form>
            </div>
        </div>  

    @else
        <div class="empty-message">
            <p>Keranjang belanja Anda kosong.</p>
            <a href="{{ route('menus.index') }}" class="btn-primary">Belanja Sekarang</a>
        </div>
    @endif
</div>

<script>
// Data alamat untuk JS
const addresses = @json($addresses);

function renderAddressDetail(addressId) {
  const address = addresses.find(a => a.id == addressId);
  const box = document.getElementById('address-detail-box');
  if (!address || !box) return;
  let html = '';
  html += `<strong>${address.label}${address.is_default ? ' (Utama)' : ''}</strong><br>`;
  html += `${address.address_line_1 || ''}${address.address_line_2 ? ', ' + address.address_line_2 : ''}`;
  if (address.city || address.state || address.postal_code || address.country) {
    html += `<br>${[address.city, address.state, address.postal_code, address.country].filter(Boolean).join(', ')}`;
  }
  html += ' <span style="font-size:13px; color:#fec6e4; margin-left:8px; cursor:pointer;">&#9660;</span>';
  box.innerHTML = html;
}

function showAddressDropdown() {
  const box = document.getElementById('address-detail-box');
  const dropdown = document.getElementById('address-dropdown-list');
  if (!box || !dropdown) return;
  let html = '';
  addresses.forEach(address => {
    html += `<div class="address-option" data-id="${address.id}" style="padding:10px 16px; cursor:pointer; color:#fff;${address.is_default ? ' font-weight:600;' : ''}">
      <div><strong>${address.label}${address.is_default ? ' (Utama)' : ''}</strong></div>
      <div style=\"font-size:13px; color:#bbb;\">${address.address_line_1 || ''}${address.address_line_2 ? ', ' + address.address_line_2 : ''}</div>
    </div>`;
  });
  dropdown.innerHTML = html;
  const rect = box.getBoundingClientRect();
  dropdown.style.display = 'block';
  dropdown.style.left = box.offsetLeft + 'px';
  dropdown.style.top = (box.offsetTop + box.offsetHeight + 4) + 'px';
}

document.addEventListener('DOMContentLoaded', function() {
  let selectedId = addresses[0] ? addresses[0].id : null;
  if (selectedId) renderAddressDetail(selectedId);
  // Ganti event pada box
  const box = document.getElementById('address-detail-box');
  const dropdown = document.getElementById('address-dropdown-list');
  if (box && dropdown) {
    box.addEventListener('click', function(e) {
      showAddressDropdown();
    });
    dropdown.addEventListener('click', function(e) {
      const opt = e.target.closest('.address-option');
      if (opt) {
        selectedId = opt.dataset.id;
        renderAddressDetail(selectedId);
        dropdown.style.display = 'none';
        // Update hidden input jika ada
        const checkoutAddressInput = document.getElementById('checkout-address-id');
        if (checkoutAddressInput) checkoutAddressInput.value = selectedId;
      }
    });
    document.addEventListener('click', function(e) {
      if (!box.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });
  }
  updateSummary();
});

function updateQuantity(button, change) {
    const itemElement = button.closest('.cart-item');
    const input = itemElement.querySelector('.quantity-input');
    
    let currentQty = parseInt(input.value);
    const maxQty = parseInt(itemElement.dataset.stock);
    
    let newQty = currentQty + change;
    if (newQty < 1) newQty = 1;
    if (newQty > maxQty) newQty = maxQty;
    
    input.value = newQty;

    // Update via AJAX
    const cartId = itemElement.dataset.id;
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
        const price = parseFloat(itemElement.dataset.price);
        const lineTotal = newQty * price;
        itemElement.querySelector('.line-total-price').textContent = lineTotal.toLocaleString('id-ID', { minimumFractionDigits: 0 });
        updateSummary();
    })
    .catch(error => {
        console.error('Error updating quantity:', error);
    });
}

function updateSummary() {
    let subtotal = 0;
    const allCartItems = [];

    document.querySelectorAll('.cart-item').forEach(item => {
        const price = parseFloat(item.dataset.price);
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        subtotal += price * quantity;
        allCartItems.push(item.dataset.id);
    });
    
    const shippingRadio = document.querySelector('input[name="shipping"]:checked');
    const shippingCost = shippingRadio ? parseFloat(shippingRadio.value) : 0;
    const total = subtotal + shippingCost;
    
    // Update summary display
    document.getElementById('summary-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID', { minimumFractionDigits: 0 });
    document.getElementById('summary-shipping').textContent = shippingCost > 0 ? 'Rp ' + shippingCost.toLocaleString('id-ID', { minimumFractionDigits: 0 }) : 'FREE';
    document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID', { minimumFractionDigits: 0 });

    // Update checkout button
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.disabled = allCartItems.length === 0;
        checkoutBtn.querySelector('span:last-child').textContent = 'Rp ' + total.toLocaleString('id-ID', { minimumFractionDigits: 0 });
    }

    // Update hidden inputs
    document.getElementById('selected-items').value = allCartItems.join(',');
    document.getElementById('shipping-cost-input').value = shippingCost;
}

// Leaflet JS for shipping map
if (typeof L !== 'undefined') {
    initShippingMap();
}
</script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1jRVv6Gk6GkG6lLrj5lZQ+1Q9Q4p1gXkG4QmQf3s=" crossorigin=""></script>
@endsection