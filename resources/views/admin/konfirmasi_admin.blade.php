@extends('layouts.app')

@section('content')
<style>
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #b0b0b0;
        --text-white: #ffffff;
        --success-color: #27ae60;
        --danger-color: #e74c3c;
        --pending-color: #f39c12;
    }

    body {
        background-color: var(--bg-dark);
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: var(--text-base);
    }

    .admin-container {
        max-width: 1250px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .admin-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .admin-header h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
        color: var(--text-important);
    }
    .admin-header p {
        color: var(--text-secondary);
        font-size: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        text-align: center;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--text-important);
    }

    .stat-number {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 600;
    }

    .stat-number.pending { color: var(--pending-color); }
    .stat-number.success { color: var(--success-color); }
    .stat-number.failed { color: var(--danger-color); }
    .stat-number.cancelled { color: var(--text-secondary); }

    .orders-section {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .section-header {
        padding: 20px 25px;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-base);
        margin: 0;
    }

    .order-item {
        padding: 20px 25px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }
    .order-item:last-child {
        border-bottom: none;
    }

    .order-info {
        flex: 1;
    }

    .order-code {
        font-weight: 700;
        color: var(--text-base);
        margin-bottom: 5px;
    }

    .order-details {
        color: var(--text-secondary);
        font-size: 14px;
    }
    .order-details strong {
        color: var(--text-base);
    }

    .order-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--bg-dark);
    }

    .status-pending { background-color: var(--pending-color); }
    .status-success { background-color: var(--success-color); color: var(--text-white); }
    .status-failed { background-color: var(--danger-color); color: var(--text-white); }
    .status-cancelled { background-color: var(--border-color); color: var(--text-secondary); }

    .btn-action {
        padding: 8px 16px;
        border: 1px solid transparent;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
    }

    .btn-confirm {
        background-color: var(--success-color);
        color: white;
    }
    .btn-confirm:hover { background-color: #2ecc71; }

    .btn-fail {
        background-color: var(--danger-color);
        color: white;
    }
    .btn-fail:hover { background-color: #e67e22; }

    .btn-cancel-order {
        background-color: var(--border-color);
        color: var(--text-secondary);
    }
    .btn-cancel-order:hover { background-color: var(--text-secondary); color: var(--card-bg); }

    .btn-detail {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-detail:hover { background-color: var(--text-white); }

    .empty-state {
        text-align: center;
        padding: 50px 25px;
        color: var(--text-secondary);
    }
    .empty-state h3 { color: var(--text-important); }

    .alert {
        max-width: 1160px;
        margin: 20px auto;
        background-color: var(--card-bg);
        color: var(--text-base);
        padding: 15px 20px;
        border-radius: 8px;
        border-left: 5px solid var(--success-color); /* Disesuaikan untuk alert sukses */
    }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>🛠️ Panel Konfirmasi Admin</h1>
        <p>Kelola dan konfirmasi pembayaran pesanan pelanggan</p>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number pending">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number success">{{ $stats['success'] }}</div>
            <div class="stat-label">Berhasil</div>
        </div>
        <div class="stat-card">
            <div class="stat-number failed">{{ $stats['failed'] }}</div>
            <div class="stat-label">Gagal</div>
        </div>
        <div class="stat-card">
            <div class="stat-number cancelled">{{ $stats['cancelled'] }}</div>
            <div class="stat-label">Dibatalkan</div>
        </div>
    </div>

    <div class="orders-section">
        <div class="section-header">
            <h2 class="section-title">Daftar Pesanan Memerlukan Konfirmasi</h2>
        </div>

        @forelse($orders as $order)
        <div class="order-item">
            <div class="order-info">
                <div class="order-code">{{ $order->order_code }}</div>
                <div class="order-details">
                    <strong>{{ $order->user->name }}</strong> • 
                    Rp {{ number_format($order->total_price, 0, ',', '.') }} • 
                    {{ $order->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            <div class="order-actions">
                @php
                    $statusClass = 'status-pending';
                    $statusText = 'Pending';
                    
                    if($order->payment_status == 'success') {
                        $statusClass = 'status-success';
                        $statusText = 'Berhasil';
                    } elseif($order->payment_status == 'failed') {
                        $statusClass = 'status-failed';
                        $statusText = 'Gagal';
                    } elseif($order->payment_status == 'cancelled') {
                        $statusClass = 'status-cancelled';
                        $statusText = 'Dibatalkan';
                    }
                @endphp
                
                <span class="badge-status {{ $statusClass }}">{{ $statusText }}</span>

                @if($order->payment_status == 'pending')
                    <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="payment_status" value="success">
                        <button type="submit" class="btn-action btn-confirm" title="Konfirmasi Pembayaran" onclick="return confirm('Anda yakin ingin mengonfirmasi pembayaran ini?')">
                            ✓ Konfirmasi
                        </button>
                    </form>

                    <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="payment_status" value="failed">
                        <button type="submit" class="btn-action btn-fail" title="Tandai Gagal" onclick="return confirm('Anda yakin ingin menandai pembayaran ini GAGAL?')">
                            ✗ Gagal
                        </button>
                    </form>
                @endif

                <a href="{{ route('orders.show', $order->id) }}" class="btn-action btn-detail">Detail</a>
            </div>
        </div>
        @empty
            <div class="empty-state">
                <h3>🎉 Semua pesanan sudah dikonfirmasi!</h3>
                <p>Tidak ada pesanan yang memerlukan konfirmasi saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection