<style>
    body {
        background-color:rgb(0, 0, 0);
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
        padding-bottom: 0;
        border-bottom: none;
    }

    .form-subtitle {
        font-size: 16px;
        color: #fff;
        text-align: center;
        margin-bottom: 28px;
        font-weight: 700; /* Bold */
        letter-spacing: 0.5px;
    }

    .form-section {
        margin-bottom: 25px;
        display: flex;
        flex-direction: column;
        gap: 0;
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

    /* Enhanced Input Styling */
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #f5c6cb;
        background-color: rgb(245, 245, 245);
        transition: all 0.3s;
        color: #111 !important; /* Teks input jadi hitam */
    }

    .form-control:focus {
        border-color: #f783ac;
        box-shadow: 0 0 0 0.2rem rgba(254, 198, 228, 0.3);
        background-color: white;
    }

    .form-control:hover {
        background-color: white;
        border-color: #f783ac;
    }

    /* Hapus icon centang pada select (kategori & status produk) */
    select.form-control {
        background-image: none !important;
    }

    .invalid-feedback {
        font-size: 13px;
        color: #e74c3c;
        margin-top: 5px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Pink-themed buttons */
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

    .btn-outline-secondary:hover {
        background-color: white;
        color: #495057;
        border-color: #adb5bd;
    }

    .error-summary {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .error-summary ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    /* Enhanced image preview with pink accents */
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
        transition: all 0.3s;
    }

    .preview-item:hover {
        transform: scale(1.03);
    }

    .image-preview {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #f5c6cb;
        background-color: rgb(245, 245, 245);
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
        transition: all 0.2s;
    }

    .remove-image:hover {
        background-color: rgba(240, 101, 149, 1);
        transform: scale(1.1);
    }

    input[type="file"] {
        cursor: pointer;
        display: block;
        margin-bottom: 6px;
    }

    input[type="file"]::file-selector-button {
        padding: 8px 12px;
        border-radius: 4px;
        background-color: rgb(254, 198, 228);
        border: none;
        color: #495057;
        font-weight: 500;
        margin-right: 10px;
        transition: all 0.2s;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: rgb(252, 177, 218);
    }

    .file-info {
        display: block;
        margin-left: 0;
        margin-top: 2px;
        color: #888;
        font-size: 0.97em;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Tambah Produk Roti</h2>
    <p class="form-subtitle">Isi formulir di bawah ini untuk menambahkan produk roti baru.</p>

    @if ($errors->any())
        <div class="error-summary">
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

        <div class="form-row">
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

        <div class="form-row">
            <div class="form-section">
                <label for="kategori" class="form-label required-label">Kategori Produk</label>
                <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="" disabled {{ old('kategori') === null ? 'selected' : '' }}>Pilih Kategori</option>
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

        <div class="form-row">
            <div class="form-section">
                <label for="available" class="form-label required-label">Status Produk</label>
                <select name="available" id="available" class="form-control @error('available') is-invalid @enderror" required>
                    <option value="" {{ old('available') === null ? 'selected' : '' }}>Pilih Status</option>
                    <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Tersedia</option>
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
                <div class="image-preview-container" id="imagePreviewContainer"></div>
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
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

        // Form validation
        const form = document.getElementById('createMenuForm');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Check required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Field ini wajib diisi';
                        field.after(errorDiv);
                    }
                }
            });
            
            if (!isValid) {
            if (!isValid) {ntDefault();
                event.preventDefault();0, behavior: 'smooth' });
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
        // Remove validation on input
        // Remove validation on input select, textarea').forEach(element => {
        form.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('input', function() {
                this.classList.remove('is-invalid');ling;
                const errorMsg = this.nextElementSibling;ns('invalid-feedback')) {
                if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                    errorMsg.remove();
                }
            });
        });
    });t></script>