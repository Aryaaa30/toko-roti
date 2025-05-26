<style>
    /* CSS kamu tetap sama */
    body {
        background-color: #fffaf2;
        font-family: 'Segoe UI', sans-serif;
    }

    .full-form-wrapper {
        padding: 60px 20px;
        background-color: #fff;
        min-height: 100vh;
    }

    .form-title {
        font-size: 32px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-section {
        max-width: 800px;
        margin: 0 auto;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 16px;
        border: 1px solid #ccc;
        background-color: #fdfdfd;
    }

    .form-control:focus {
        border-color: #e67e22;
        box-shadow: 0 0 0 0.2rem rgba(230, 126, 34, 0.2);
    }

    .invalid-feedback {
        font-size: 14px;
        color: #e74c3c;
        margin-top: 5px;
    }

    .btn-primary {
        background-color: #e67e22;
        border-color: #e67e22;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #d35400;
        border-color: #d35400;
    }

    .btn-outline-secondary {
        border: 2px solid #7f8c8d;
        color: #7f8c8d;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
    }

    .btn-outline-secondary:hover {
        background-color: #ecf0f1;
        color: #2c3e50;
    }

    .alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="full-form-wrapper">
    <div class="form-section">
        <h2 class="form-title">Tambah Produk Roti</h2>

        @if ($errors->any())
            <div class="alert">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="form-grid mb-4">
                <div>
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Masukkan nama produk" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" id="price" min="0" step="0.01"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}" placeholder="Contoh: 15000" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Deskripsikan produk roti secara detail" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tambahan field available -->
            <div class="mb-4">
                <label for="available">Status Produk</label>
                <select name="available" id="available" class="form-control @error('available') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('available')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image">Gambar Produk <small class="text-muted">(opsional)</small></label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <small class="form-text text-muted">Format: jpg, png. Maksimal ukuran 2MB.</small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
