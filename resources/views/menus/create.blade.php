@extends('layouts.app')

@section('content')

<style>
    /* STYLE INI DIAMBIL PENUH DARI FILE EDIT.BLADE.PHP YANG SUDAH FINAL */
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        --placeholder: rgb(36, 36, 36); 
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #909090; 
        --text-white: #ffffff;
        --danger-color: #e74c3c;
    }

    body {
        background-color: var(--bg-dark);
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: var(--text-base);
    }

    .form-container {
        max-width: 1230px; /* Disesuaikan agar tidak terlalu lebar */
        margin: 30px auto;
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

    .form-section {
        margin-bottom: 20px;
    }
    
    .form-grid { /* Menggunakan form-grid untuk konsistensi */
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
        background-color: var(--placeholder);
        color: var(--text-base);
        font-size: 15px;
        transition: all 0.2s ease-in-out;
    }
    
    .form-control::placeholder {
        color: var(--text-secondary);
        opacity: 1; 
    }
    .form-control::-moz-placeholder {
        color: var(--text-secondary);
        opacity: 1;
    }
    .form-control:-ms-input-placeholder {
        color: var(--text-secondary);
    }
    .form-control::-ms-input-placeholder {
        color: var(--text-secondary);
    }
    
    .form-control option {
        background-color: var(--placeholder);
        color: var(--text-base);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--text-important);
        background-color: var(--placeholder);
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
    
    .file-info {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 8px;
    }

    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
        padding: 15px;
        background-color: var(--placeholder);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        min-height: 130px;
    }

    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .preview-item .image-preview {
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
    
    .form-actions { /* Menggunakan form-actions untuk konsistensi */
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

    .btn-save {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-save:hover {
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
    
    .alert-danger { /* Menggunakan alert-danger untuk konsistensi */
        background-color: rgba(231, 76, 60, 0.1);
        border: 1px solid var(--danger-color);
        color: var(--text-base);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .alert-danger ul {
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
        <h2 class="form-title">Tambah Produk Roti</h2>
        <p class="form-subtitle">Isi formulir di bawah ini untuk menambahkan produk roti baru.</p>
    </div>

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" id="createMenuForm">
        @csrf

        <div class="form-grid">
            <div class="form-section">
                <label for="name" class="form-label required-label">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Contoh: Roti Sosis Keju" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="price" class="form-label required-label">Harga (Rp)</label>
                <input type="number" name="price" id="price" min="0" step="100" 
                       class="form-control @error('price') is-invalid @enderror" 
                       value="{{ old('price') }}" placeholder="Contoh: 15000" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-section">
                <label for="kategori" class="form-label required-label">Kategori Produk</label>
                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="" disabled {{ old('kategori') === null ? 'selected' : '' }}>-- Pilih Kategori --</option>
                    <option value="Roti Manis" {{ old('kategori') == 'Roti Manis' ? 'selected' : '' }}>Roti Manis</option>
                    <option value="Roti Tawar" {{ old('kategori') == 'Roti Tawar' ? 'selected' : '' }}>Roti Tawar</option>
                    <option value="Kue (Cake)" {{ old('kategori') == 'Kue (Cake)' ? 'selected' : '' }}>Kue (Cake)</option>
                    <option value="Donat" {{ old('kategori') == 'Donat' ? 'selected' : '' }}>Donat</option>
                    <option value="Pastry" {{ old('kategori') == 'Pastry' ? 'selected' : '' }}>Pastry</option>
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="stok" class="form-label required-label">Stok Produk</label>
                <input type="number" name="stok" id="stok" min="0" 
                       class="form-control @error('stok') is-invalid @enderror" 
                       value="{{ old('stok', 0) }}" placeholder="Masukkan jumlah stok" required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <label for="description" class="form-label required-label">Deskripsi Produk</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                      placeholder="Deskripsikan produk roti secara detail" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-grid">
            <div class="form-section">
                <label for="available" class="form-label required-label">Status Produk</label>
                <select name="available" id="available" class="form-control @error('available') is-invalid @enderror" required>
                    <option value="" disabled {{ old('available') === null ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="1" {{ old('available', '1') == '1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('available')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-section">
                <label for="images" class="form-label">Gambar Produk</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="file-info">Format: JPG, PNG, GIF (Maks. 2MB per gambar)</small>
            </div>
        </div>
        
        <div class="form-section">
            <label class="form-label">Preview Gambar</label>
            <div class="image-preview-container" id="imagePreviewContainer"></div>
        </div>

        <div class="form-actions">
            <a href="{{ route('menus.index') }}" class="btn-action btn-cancel">Batal</a>
            <button type="submit" class="btn-action btn-save">Simpan Produk</button>
        </div>
    </form>
</div>

<script>
    // SCRIPT DIAMBIL DARI KODE YANG ANDA BERIKAN, HANYA SEDIKIT PENYESUAIAN
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const form = document.getElementById('createMenuForm');
        
        let imageFiles = new DataTransfer();

        // Image preview functionality
        imageInput.addEventListener('change', function(event) {
            const files = event.target.files;
            
            for (const file of files) {
                if (!file.type.match('image.*')) continue;
                imageFiles.items.add(file);
            }
            
            // Assign the updated file list to the input
            imageInput.files = imageFiles.files;
            
            renderPreviews();
        });

        function renderPreviews() {
            previewContainer.innerHTML = ''; // Clear existing previews
            
            Array.from(imageFiles.files).forEach((file, index) => {
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
                    removeBtn.type = 'button'; // Prevent form submission
                    
                    removeBtn.onclick = function() {
                        imageFiles.items.remove(index);
                        imageInput.files = imageFiles.files;
                        renderPreviews(); // Re-render the previews
                    };
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        }

        // Form validation (optional, Laravel validation is primary)
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            form.querySelectorAll('[required]').forEach(field => {
                field.classList.remove('is-invalid');
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.textContent = '';
                }

                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        errorMsg.textContent = 'Field ini wajib diisi.';
                    }
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
</script>

@endsection