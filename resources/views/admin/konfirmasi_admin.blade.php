@extends('layouts.app')

@section('content')
<style>
    .admin-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
    }

    .admin-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        border-radius: 12px;
    }

    .admin-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    .stat-number {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 14px;
    }

    .pending { color: #f39c12; }
    .success { color: #27ae60; }
    .failed { color: #e74c3c; }
    .cancelled { color: #95a5a6; }

    .orders-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .section-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #dee2e6;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }

    .order-item {
        padding: 20px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-info {
        flex: 1;
    }

    .order-code {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .order-details {
        color: #7f8c8d;
        font-size: 14px;
    }

    .order-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .payment-pending { background-color: #f39c12; color: white; }
    .payment-success { background-color: #27ae60; color: white; }
    .payment-failed { background-color: #e74c3c; color: white; }
    .payment-cancelled { background-color: #95a5a6; color: white; }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #27ae60;
        color: white;
    }

    .btn-success:hover {
        background-color: #229954;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-secondary {
        background-color: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
    }

    .btn-detail {
        background-color: #3498db;
        color: white;
    }

    .btn-detail:hover {
        background-color: #2980b9;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>🛠️ Panel Konfirmasi Admin</h1>
        <p>Kelola dan konfirmasi pembayaran pesanan pelanggan</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Statistics -->
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

    <!-- Orders List -->
    <div class="orders-section">
        <div class="section-header">
            <h2 class="section-title">Daftar Pesanan Memerlukan Konfirmasi</h2>
        </div>

        @if($orders->count() > 0)
            @foreach($orders as $order)
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
                        $paymentClass = 'payment-pending';
                        $paymentText = 'Pending';
                        
                        if($order->payment_status == 'success') {
                            $paymentClass = 'payment-success';
                            $paymentText = 'Berhasil';
                        } elseif($order->payment_status == 'failed') {
                            $paymentClass = 'payment-failed';
                            $paymentText = 'Gagal';
                        } elseif($order->payment_status == 'cancelled') {
                            $paymentClass = 'payment-cancelled';
                            $paymentText = 'Dibatalkan';
                        }
                    @endphp
                    
                    <span class="status-badge {{ $paymentClass }}">{{ $paymentText }}</span>

                    @if($order->payment_status == 'pending')
                        <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="success">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pembayaran berhasil?')">
                                ✓
                            </button>
                        </form>

                        <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="failed">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tandai pembayaran gagal?')">
                                ✗
                            </button>
                        </form>

                        <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="cancelled">
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Batalkan pembayaran?')">
                                ⊘
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-detail">Detail</a>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <h3>🎉 Semua pesanan sudah dikonfirmasi!</h3>
                <p>Tidak ada pesanan yang memerlukan konfirmasi saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection