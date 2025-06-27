@extends('layouts.app')

@section('content')

<style>
    /* Saran: Pindahkan style global seperti :root dan style umum lainnya 
      ke file CSS utama Anda (misal: app.css) untuk best practice.
    */
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        --placeholder-bg: rgb(25, 25, 25);
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228);
        --text-secondary: #909090;
        --text-white: #ffffff;
        --danger-color: #e74c3c;
        --success-color: #2ecc71;
    }

    .auth-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: calc(100vh - 80px); /* Adjust 80px based on your nav height */
        padding: 40px 20px;
        box-sizing: border-box;
    }

    .form-container {
        width: 100%;
        max-width: 800px; /* Lebarkan container untuk layout 2 kolom */
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

    /* Kunci dari layout 2 kolom */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Dua kolom dengan lebar sama */
        gap: 25px; /* Jarak antar kolom */
        margin-bottom: 20px;
    }

    .form-section {
        /* Hapus margin-bottom dari sini karena sudah dihandle oleh .form-grid */
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

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background-color: var(--placeholder-bg);
        color: var(--text-base);
        font-size: 15px;
        transition: all 0.2s ease-in-out;
    }

    .form-control::placeholder { color: var(--text-secondary); opacity: 1; }

    .form-control:focus {
        outline: none;
        border-color: var(--text-important);
        background-color: var(--bg-dark);
        box-shadow: 0 0 0 3px rgba(254, 198, 228, 0.15);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 13px;
        margin-top: 6px;
        display: block;
    }
    
    .password-toggle-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-secondary);
    }
    input[type="password"].form-control { padding-right: 45px; }

    .password-info {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0 0 8px 0; /* Sesuaikan margin */
    }

    ul.password-reqs {
        margin: 0 0 24px 20px;
        padding: 0;
        list-style-type: disc;
        font-size: 14px;
        line-height: 1.5;
        color: var(--danger-color);
    }
    ul.password-reqs li.valid { color: var(--success-color); }

    .checkbox-container {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-top: 10px;
      margin-bottom: 24px;
      padding: 12px;
      background-color: var(--placeholder-bg);
      border-radius: 8px;
    }
    .checkbox-container input[type="checkbox"] {
      margin-top: 3px;
      width: 18px;
      height: 18px;
      cursor: pointer;
      flex-shrink: 0;
    }
    .checkbox-container label {
      font-size: 14px;
      line-height: 1.4;
      color: var(--text-secondary);
      user-select: none;
    }

    .form-actions {
        margin-top: 30px;
    }

    .btn-action {
        width: 100%;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    .btn-submit {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-submit:hover { background-color: var(--text-white); }
    
    .login-text {
        margin-top: 32px;
        font-weight: 400;
        font-size: 15px;
        text-align: center;
        color: var(--text-secondary);
    }
    .login-text a {
        font-weight: 600;
        color: var(--text-important);
        text-decoration: none;
    }
    .login-text a:hover { text-decoration: underline; }
    
    /* Responsive: Kembali ke 1 kolom di layar kecil */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-container {
            max-width: 100%;
        }
        .auth-wrapper {
            padding: 20px 10px;
        }
    }
</style>

<div class="auth-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Create an Account</h2>
            <p class="form-subtitle">Daftar untuk menjadi bagian dari Toko Roti kami.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-grid">
                <div class="form-section">
                    <label for="name" class="form-label required-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-section">
                    <label for="username" class="form-label required-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Masukkan username unik" required autocomplete="username">
                    @error('username')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="form-section" style="margin-bottom: 20px;">
                <label for="email" class="form-label required-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-section">
                    <label for="password" class="form-label required-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Buat password Anda" required autocomplete="new-password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                        </span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="password-confirm" class="form-label required-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Ulangi password Anda" required autocomplete="new-password">
                         <span class="password-toggle-icon" onclick="togglePasswordVisibility('password-confirm', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                        </span>
                    </div>
                </div>
            </div>

            <p class="password-info">Password Anda harus berisi:</p>
            <ul class="password-reqs" id="password-requirements">
                <li id="req-length">Minimal 8 karakter</li>
                <li id="req-number">Minimal 1 angka</li>
                <li id="req-case">Minimal satu huruf besar & kecil</li>
            </ul>

            <div class="checkbox-container">
                <input type="checkbox" id="agree" name="agree" required>
                <label for="agree">Dengan membuat akun, Anda menyetujui Kebijakan Privasi dan Ketentuan kami. Kami akan mengirimkan Anda informasi terbaru tentang semua hal tentang Toko Roti termasuk perasa, produk baru, dan penawaran khusus! Berhenti berlangganan kapan saja.</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-action btn-submit">Sign Up</button>
            </div>
        </form>

        <p class="login-text">
            Already have an account? 
            <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const reqLength = document.getElementById('req-length');
    const reqNumber = document.getElementById('req-number');
    const reqCase = document.getElementById('req-case');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const value = passwordInput.value;
            value.length >= 8 ? reqLength.classList.add('valid') : reqLength.classList.remove('valid');
            /\d/.test(value) ? reqNumber.classList.add('valid') : reqNumber.classList.remove('valid');
            /[a-z]/.test(value) && /[A-Z]/.test(value) ? reqCase.classList.add('valid') : reqCase.classList.remove('valid');
        });
    }

    const eyeSlashIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/></svg>`;
    const eyeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>`;

    function togglePasswordVisibility(inputId, iconElement) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            iconElement.innerHTML = eyeSlashIcon;
        } else {
            input.type = "password";
            iconElement.innerHTML = eyeIcon;
        }
    }
</script>

@endsection