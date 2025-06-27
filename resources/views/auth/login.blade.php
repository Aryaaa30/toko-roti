@extends('layouts.app')

@section('content')

<style>
    /* Menggunakan variabel dan style yang sama persis dengan register.blade.php untuk konsistensi */
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        --placeholder-bg: rgb(25, 25, 25);
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
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
        min-height: calc(100vh - 80px); /* Sesuaikan 80px dengan tinggi navbar Anda */
        padding: 40px 20px;
        box-sizing: border-box;
    }

    /* Ukuran container dibuat lebih kecil karena form login lebih simpel */
    .form-container {
        width: 100%;
        max-width: 480px; 
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

    .form-section {
        margin-bottom: 20px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-base);
        margin-bottom: 8px;
        display: block;
        font-size: 15px;
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
    
    /* Style untuk Show/Hide Password Icon */
    .password-toggle-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-secondary);
    }
    input[type="password"].form-control { padding-right: 45px; }
    
    /* Wrapper untuk "Remember Me" dan "Forgot Password" */
    .remember-forgot-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
    }
    .remember-me input[type="checkbox"] {
        cursor: pointer;
    }

    .forgot-password a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }
    .forgot-password a:hover {
        color: var(--text-important);
        text-decoration: underline;
    }

    /* Tombol Aksi */
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
        display: block;
    }
    .btn-submit {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-submit:hover { background-color: var(--text-white); }
    
    /* Garis Pemisah */
    .divider {
        margin: 32px 0;
        height: 1px;
        background-color: var(--border-color);
        border: none;
    }

    /* Bagian Sign Up */
    .signup-section {
        text-align: center;
    }
    .signup-section h3 {
        font-weight: 600;
        font-size: 18px;
        color: var(--text-base);
        margin: 0 0 8px 0;
    }
    .signup-section p {
        color: var(--text-secondary);
        font-size: 14px;
        margin-bottom: 20px;
    }
    .btn-outline {
        background-color: transparent;
        color: var(--text-important);
        border-color: var(--text-important);
    }
    .btn-outline:hover {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    
    /* Status Message */
    .status-message {
        background-color: rgba(46, 204, 113, 0.1);
        border: 1px solid var(--success-color);
        color: var(--text-base);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 520px) {
        .form-container {
            padding: 20px;
        }
        .auth-wrapper {
            padding: 20px 10px;
            align-items: flex-start;
        }
        .remember-forgot-wrapper {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>

<div class="auth-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Log In</h2>
        </div>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username or Email -->
            <div class="form-section">
                <label for="username" class="form-label">Username or Email</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Masukkan username atau email">
                @error('username')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-section">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                    <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
                    </span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            
            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot-wrapper">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="form-section">
                <button type="submit" class="btn-action btn-submit">Log In</button>
            </div>
        </form>

        <div class="divider"></div>

        <div class="signup-section">
            <h3>Don't have an account?</h3>
            <p>Create an account to get the best experience.</p>
            <a href="{{ route('register') }}" class="btn-action btn-outline">Create Account</a>
        </div>
    </div>
</div>

<script>
    // Script ini sama persis dengan di halaman registrasi
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