@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: rgb(0, 0, 0);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: rgb(254, 198, 228); /* Pink */
        margin-bottom: 10px;
        text-align: center;
    }

    .form-subtitle {
        font-size: 16px;
        color: #333;
        text-align: center;
        margin-bottom: 28px;
        font-weight: 500;
    }

    .form-section {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    .required-label::after {
        content: ' *';
        color: #e74c3c;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #f5c6cb;
        background-color: rgb(245, 245, 245);
        transition: all 0.3s;
        color: #111;
    }

    .form-control:focus {
        border-color: #f783ac;
        box-shadow: 0 0 0 0.2rem rgba(254, 198, 228, 0.3);
        background-color: white;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
        border: none;
    }

    .btn-primary {
        background-color: #f783ac;
        color: white;
    }

    .btn-primary:hover {
        background-color: #f06595;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        background-color: rgb(245, 245, 245);
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .preview-item {
        position: relative;
        width: 120px;
        height: 120px;
    }

    .image-preview {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #f5c6cb;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background-color: rgba(247, 131, 172, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">
    <a href="{{ route('birthday') }}" class="btn btn-sm" style="margin-bottom: 15px; color: #f783ac;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h2 class="form-title">Tambah Kue Ulang Tahun</h2>
    <p class="form-subtitle">Isi formulir di bawah ini untuk menambahkan kue ulang tahun baru.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" id="createBirthdayForm">
        @csrf
        <input type="hidden" name="kategori" value="birthday">

        <div class="form-row">
            <div class="form-section">
                <label for="name" class="form-label required-label">Nama Kue</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Contoh: Kue Ulang Tahun Coklat" required>
            </div>

            <div class="form-section">
                <label for="price" class="form-label required-label">Harga (Rp)</label>
                <input type="number" name="price" id="price" min="0" step="1000" 
                       class="form-control @error('price') is-invalid @enderror" 
                       value="{{ old('price') }}" placeholder="Contoh: 250000" required>
            </div>
        </div>

        <div class="form-section">
            <label for="flavor" class="form-label required-label">Rasa Kue</label>
            <select name="flavor" id="flavor" class="form-control @error('flavor') is-invalid @enderror" required>
                <option value="" disabled {{ old('flavor') === null ? 'selected' : '' }}>Pilih Rasa</option>
                <option value="Coklat" {{ old('flavor') == 'Coklat' ? 'selected' : '' }}>Coklat</option>
                <option value="Vanilla" {{ old('flavor') == 'Vanilla' ? 'selected' : '' }}>Vanilla</option>
                <option value="Strawberry" {{ old('flavor') == 'Strawberry' ? 'selected' : '' }}>Strawberry</option>
                <option value="Red Velvet" {{ old('flavor') == 'Red Velvet' ? 'selected' : '' }}>Red Velvet</option>
                <option value="Tiramisu" {{ old('flavor') == 'Tiramisu' ? 'selected' : '' }}>Tiramisu</option>
                <option value="Blueberry" {{ old('flavor') == 'Blueberry' ? 'selected' : '' }}>Blueberry</option>
            </select>
        </div>

        <div class="form-section">
            <label for="description" class="form-label required-label">Deskripsi Kue</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                      placeholder="Deskripsikan kue ulang tahun secara detail" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-section">
                <label for="stok" class="form-label required-label">Stok</label>
                <input type="number" name="stok" id="stok" min="0" 
                       class="form-control @error('stok') is-invalid @enderror" 
                       value="{{ old('stok', 0) }}" placeholder="Masukkan jumlah stok" required>
            </div>

            <div class="form-section">
                <label for="available" class="form-label required-label">Status Ketersediaan</label>
                <select name="available" id="available" class="form-control @error('available') is-invalid @enderror" required>
                    <option value="1" {{ old('available', '1') == '1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>
        </div>

        <div class="form-section">
            <label for="images" class="form-label">Gambar Kue</label>
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
            <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB per gambar)</small>
            <div class="image-preview-container" id="imagePreviewContainer"></div>
        </div>

        <div class="btn-group">
            <a href="{{ route('birthday') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Kue</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        document.getElementById('images').addEventListener('change', function(event) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';
            
            const files = event.target.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    if (!file.type.match('image.*')) continue;
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        
                        const img = document.createElement('img');
                        img.className = 'image-preview';
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = function() {
                            previewItem.remove();
                        };
                        
                        previewItem.appendChild(img);
                        previewItem.appendChild(removeBtn);
                        container.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    });
</script>
@endsection