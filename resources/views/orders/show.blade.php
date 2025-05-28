<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
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

        .card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 24px;
            max-width: 900px;
            margin: 30px auto;
        }

        .card-section {
            margin-bottom: 20px;
        }

        .card-section h3 {
            font-weight: 700;
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 16px;
            border-bottom: 2px solid #e67e22;
            padding-bottom: 8px;
        }

        .info-item {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 8px;
        }

        .address-input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table thead tr {
            background-color: #f1c40f;
            color: #2c3e50;
            font-weight: 600;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .btn-primary, .btn-pay {
            background-color: #e67e22;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary:hover, .btn-pay:hover {
            background-color: #d35400;
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
<div class="header-area">
    <h1>Detail Pesanan {{ $order->order_code }}</h1>
</div>

<div class="card">
    <div class="card-section">
        <p class="info-item"><strong>Status Pesanan:</strong> {{ ucfirst($order->status) }}</p>
        <p class="info-item"><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p class="info-item"><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p class="info-item"><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

        <form method="POST" action="{{ route('orders.update_address', $order->id) }}">
            @csrf
            @method('PUT')
            <label class="info-item"><strong>Alamat Pengiriman:</strong></label>
            <textarea name="shipping_address" class="address-input" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
            <button type="submit" class="btn-primary">Simpan Alamat</button>
        </form>
    </div>

    <div class="card-section">
        <h3>Detail Item Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->menu->name ?? 'Produk tidak ditemukan' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tombol bayar Midtrans -->
    <button class="btn-pay" id="pay-button">Bayar Sekarang</button>

    <a href="{{ route('orders.index') }}" class="btn-primary">Kembali ke Daftar Pesanan</a>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        fetch("{{ route('orders.getSnapToken', $order->id) }}")
            .then(response => response.json())
            .then(data => {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran sukses!");
                        window.location.reload();
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran.");
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal.");
                        window.location.reload();
                    },
                    onClose: function() {
                        alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
                    }
                });
            });
    });
</script>
</body>
</html>
