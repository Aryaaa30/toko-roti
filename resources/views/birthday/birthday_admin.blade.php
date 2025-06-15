@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #000;
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }
    
    .admin-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #333;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: rgb(254, 198, 228);
        margin: 0;
    }
    
    .btn-add {
        background-color: rgb(254, 198, 228);
        color: #000;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-add:hover {
        background-color: #f783ac;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(254, 198, 228, 0.3);
        text-decoration: none;
        color: #000;
    }
    
    .products-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #111;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .products-table th {
        background-color: #222;
        color: rgb(254, 198, 228);
        font-weight: 600;
        text-align: left;
        padding: 15px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .products-table td {
        padding: 15px;
        border-top: 1px solid #333;
        color: #eee;
        font-size: 15px;
        vertical-align: middle;
    }
    
    .products-table tr:hover {
        background-color: #1a1a1a;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
    }
    
    .product-name {
        font-weight: 600;
        color: #fff;
    }
    
    .product-price {
        font-weight: 600;
        color: #f783ac;
    }
    
    .product-stock {
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }
    
    .status-available {
        background-color: rgba(46, 213, 115, 0.2);
        color: #2ed573;
        border: 1px solid rgba(46, 213, 115, 0.3);
    }
    
    .status-unavailable {
        background-color: rgba(255, 71, 87, 0.2);
        color: #ff4757;
        border: 1px solid rgba(255, 71, 87, 0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-edit {
        background-color: rgba(254, 198, 228, 0.2);
        color: rgb(254, 198, 228);
        border: 1px solid rgba(254, 198, 228, 0.3);
    }
    
    .btn-edit:hover {
        background-color: rgba(254, 198, 228, 0.3);
        text-decoration: none;
        color: rgb(254, 198, 228);
    }
    
    .btn-delete {
        background-color: rgba(255, 71, 87, 0.2);
        color: #ff4757;
        border: 1px solid rgba(255, 71, 87, 0.3);
    }
    
    .btn-delete:hover {
        background-color: rgba(255, 71, 87, 0.3);
        text-decoration: none;
        color: #ff4757;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #111;
        border-radius: 10px;
    }
    
    .empty-state-icon {
        font-size: 60px;
        color: #444;
        margin-bottom: 20px;
    }
    
    .empty-state-title {
        font-size: 20px;
        font-weight: 600;
        color: #ddd;
        margin-bottom: 10px;
    }
    
    .empty-state-text {
        color: #888;
        margin-bottom: 25px;
        font-size: 15px;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 30px;
    }
    
    .page-item {
        list-style: none;
    }
    
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background-color: #222;
        color: #ddd;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .page-link:hover {
        background-color: #333;
        color: #fff;
        text-decoration: none;
    }
    
    .page-item.active .page-link {
        background-color: rgb(254, 198, 228);
        color: #000;
    }
    
    .search-container {
        margin-bottom: 20px;
    }
    
    .search-input {
        width: 100%;
        max-width: 400px;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #333;
        background-color: #222;
        color: #fff;
        font-size: 15px;
    }
    
    .search-input:focus {
        outline: none;
        border-color: rgb(254, 198, 228);
        box-shadow: 0 0 0 2px rgba(254, 198, 228, 0.2);
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .products-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="admin-container">
    <div class="page-header">
        <h1 class="page-title">Manajemen Kue Ulang Tahun</h1>
        <a href="{{ route('menus.create') }}?type=birthday" class="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
            </svg>
            Tambah Kue Ulang Tahun
        </a>
    </div>
    
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Cari kue ulang tahun..." id="searchInput">
    </div>
    
    @if(isset($birthdayCakes) && count($birthdayCakes) > 0)
        <table class="products-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Kue</th>
                    <th>Harga</th>
                    <th>Ukuran</th>
                    <th>Rasa</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($birthdayCakes as $cake)
                <tr>
                    <td>
                        @if($cake->images)
                            @php
                                $images = json_decode($cake->images);
                                $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/'.$firstImage) }}" alt="{{ $cake->name }}" class="product-image">
                            @else
                                <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: #666; font-size: 10px;">No Image</span>
                                </div>
                            @endif
                        @else
                            <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #666; font-size: 10px;">No Image</span>
                            </div>
                        @endif
                    </td>
                    <td class="product-name">{{ $cake->name }}</td>
                    <td class="product-price">Rp {{ number_format($cake->price, 0, ',', '.') }}</td>
                    <td>{{ $cake->size ?? '-' }}</td>
                    <td>{{ $cake->flavor ?? '-' }}</td>
                    <td class="product-stock">{{ $cake->stok }}</td>
                    <td>
                        <span class="status-badge {{ $cake->available ? 'status-available' : 'status-unavailable' }}">
                            {{ $cake->available ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('menus.edit', $cake->id) }}" class="btn-action btn-edit">Edit</a>
                            <form action="{{ route('menus.destroy', $cake->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kue ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if(isset($birthdayCakes) && method_exists($birthdayCakes, 'links'))
            <div class="pagination-container">
                {{ $birthdayCakes->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🎂</div>
            <h3 class="empty-state-title">Belum ada kue ulang tahun</h3>
            <p class="empty-state-text">Tambahkan kue ulang tahun pertama Anda dengan mengklik tombol di atas.</p>
            <a href="{{ route('menus.create') }}?type=birthday" class="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                </svg>
                Tambah Kue Ulang Tahun
            </a>
        </div>
    @endif
</div>

<script>
    // Simple search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('.products-table tbody tr');
                
                tableRows.forEach(row => {
                    const name = row.querySelector('.product-name').textContent.toLowerCase();
                    const flavor = row.cells[4].textContent.toLowerCase();
                    const size = row.cells[3].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || flavor.includes(searchTerm) || size.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection