
@extends('layouts.app')

@section('content')

<style>
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        /* Warna background untuk input */
        --placeholder: rgb(25, 25, 25); 
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #909090; /* Warna untuk teks placeholder agar kontras */
        --text-white: #ffffff;
        --danger-color: #e74c3c;
    }

    body {
        background-color: var(--bg-dark);
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: var(--text-base);
    }

    /* --- Form Container & Header --- */
    .form-container {
        max-width: 1230px;
        margin: 40px auto;
        padding: 30px 40px;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .form-header .form-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-important);
        margin-bottom: 5px;
    }

    .form-header .form-subtitle {
        font-size: 16px;
        color: var(--text-secondary);
    }

    /* --- Form Elements --- */
    .form-section {
        margin-bottom: 20px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-base);
        margin-bottom: 8px;
        display: block;
        font-size: 15px;
    }

    .required-label::after {
        content: ' *';
        color: var(--text-important);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        /* DIGANTI: Menggunakan var(--placeholder) untuk background */
        background-color: var(--placeholder);
        color: var(--text-base);
        font-size: 15px;
        transition: all 0.2s ease-in-out;
    }
    
    /* DIGANTI: Warna teks placeholder diubah agar kontras dengan background baru */
    .form-control::placeholder {
        color: var(--text-secondary);
        opacity: 1; 
    }
    .form-control::-moz-placeholder { /* Firefox */
        color: var(--text-secondary);
        opacity: 1;
    }
    .form-control:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: var(--text-secondary);
    }
    .form-control::-ms-input-placeholder { /* Microsoft Edge */
        color: var(--text-secondary);
    }
    
    .form-control option {
        /* Pilihan dropdown tetap gelap agar konsisten */
        background-color: var(--placeholder);
        color: var(--text-base);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--text-important);
        background-color: var(--bg-dark); /* Background sedikit lebih gelap saat fokus */
        box-shadow: 0 0 0 3px rgba(254, 198, 228, 0.15);
    }
    
    .form-control.is-invalid {
        border-color: var(--danger-color);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 13px;
        margin-top: 6px;
    }
    
    /* --- Image Upload & Preview --- */
    .file-info {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 8px;
    }

    .current-images, .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
        padding: 15px;
        background-color: var(--placeholder);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        min-height: 100px;
    }

    .image-item, .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .image-item img, .preview-item .image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }
    
    .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background-color: var(--danger-color);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        transition: transform 0.2s;
    }
    .remove-image:hover {
        transform: scale(1.1);
    }

    /* --- Action Buttons --- */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .btn-action {
        padding: 10px 25px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .btn-update {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-update:hover {
        background-color: var(--text-white);
        color: var(--bg-dark);
    }

    .btn-cancel {
        background-color: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    .btn-cancel:hover {
        background-color: var(--border-color);
        color: var(--text-white);
    }
    
    .alert {
        background-color: rgba(231, 76, 60, 0.1);
        border: 1px solid var(--danger-color);
        color: var(--text-base);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-container {
            padding: 20px;
        }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2 class="form-title">Edit Produk Roti</h2>
        <p class="form-subtitle">Perbarui informasi produk roti Anda di sini.</p>
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" id="editMenuForm">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-section">
                <label for="name" class="form-label required-label">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $menu->name) }}" placeholder="Contoh: Roti Coklat Keju" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="price" class="form-label required-label">Harga (Rp)</label>
                <input type="number" name="price" id="price" min="0" step="100" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $menu->price) }}" placeholder="Contoh: 15000" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-section">
                <label for="kategori" class="form-label required-label">Kategori Produk</label>
                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="" disabled>-- Pilih Kategori --</option>
                    <option value="Roti Manis" {{ old('kategori', $menu->kategori) == 'Roti Manis' ? 'selected' : '' }}>Roti Manis</option>
                    <option value="Roti Tawar" {{ old('kategori', $menu->kategori) == 'Roti Tawar' ? 'selected' : '' }}>Roti Tawar</option>
                    <option value="Kue (Cake)" {{ old('kategori', $menu->kategori) == 'Kue (Cake)' ? 'selected' : '' }}>Kue (Cake)</option>
                    <option value="Donat" {{ old('kategori', $menu->kategori) == 'Donat' ? 'selected' : '' }}>Donat</option>
                    <option value="Pastry" {{ old('kategori', $menu->kategori) == 'Pastry' ? 'selected' : '' }}>Pastry</option>
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="stok" class="form-label required-label">Stok Produk</label>
                <input type="number" name="stok" id="stok" min="0" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $menu->stok) }}" placeholder="Contoh: 50" required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <label for="description" class="form-label required-label">Deskripsi Produk</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi singkat mengenai produk di sini..." required>{{ old('description', $menu->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-grid">
             <div class="form-section">
                <label for="available" class="form-label required-label">Status Produk</label>
                <select name="available" id="available" class="form-control @error('available') is-invalid @enderror" required>
                    <option value="" disabled>-- Pilih Status --</option>
                    <option value="1" {{ old('available', $menu->available) == '1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ old('available', $menu->available) == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('available')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="images" class="form-label">Gambar Produk Baru</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                @error('images.*')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="file-info">Unggah gambar baru akan menggantikan semua gambar saat ini.</p>
            </div>
        </div>
        
        <div class="form-section">
             <label class="form-label">Gambar Produk</label>
             <div id="imagePreviewContainer" class="image-preview-container" style="display: none;"></div>
             @if (($menu->images && !empty(json_decode($menu->images))) || $menu->image)
                 <div class="current-images" id="currentImagesContainer">
                    @php
                        $images = $menu->images ? json_decode($menu->images) : ($menu->image ? [$menu->image] : []);
                    @endphp
                    @foreach($images as $image)
                        @if($image)
                        <div class="image-item">
                            <img src="{{ asset('storage/' . $image) }}" alt="Current image">
                        </div>
                        @endif
                    @endforeach
                 </div>
             @else
                <div class="current-images" id="currentImagesContainer">
                    <p class="file-info" style="width: 100%; text-align: center;">Belum ada gambar untuk produk ini.</p>
                </div>
             @endif
        </div>
        
        <div class="form-actions">
            <a href="{{ route('menus.index') }}" class="btn-action btn-cancel">Batal</a>
            <button type="submit" class="btn-action btn-update">Update Produk</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const currentContainer = document.getElementById('currentImagesContainer');
        previewContainer.innerHTML = ''; // Clear previous previews

        const files = event.target.files;
        if (files.length > 0) {
            // Hide current images and show the preview container for new ones
            if(currentContainer) currentContainer.style.display = 'none';
            previewContainer.style.display = 'flex';

            for (const file of files) {
                if (!file.type.startsWith('image/')) continue;

                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';

                const img = document.createElement('img');
                img.className = 'image-preview';
                
                const reader = new FileReader();
                reader.onload = () => {
                    img.src = reader.result;
                };
                reader.readAsDataURL(file);

                previewItem.appendChild(img);
                previewContainer.appendChild(previewItem);
            }
        } else {
            // If no files are selected, show the current images again
            if(currentContainer) currentContainer.style.display = 'flex';
            previewContainer.style.display = 'none';
        }
    });
</script>

@endsection
