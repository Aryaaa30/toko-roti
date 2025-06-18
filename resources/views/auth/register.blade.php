<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create Account Modal</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background: #00000080;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .modal {
      background: #fff;
      border-radius: 8px;
      width: 100%;
      max-width: 420px;
      padding: 32px 32px 40px 32px;
      position: relative;
      box-shadow: 0 0 15px rgb(0 0 0 / 0.3);
    }
    .close-btn {
      position: absolute;
      top: 24px;
      right: 24px;
      font-size: 24px;
      font-weight: 700;
      line-height: 1;
      color: #000;
      cursor: pointer;
      border: none;
      background: transparent;
    }
    h2 {
      font-weight: 700;
      font-size: 20px;
      line-height: 1.2;
      text-align: center;
      margin: 0 0 32px 0;
      color: #222222;
    }
    form {
      width: 100%;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      border: 1.5px solid #222222;
      border-radius: 6px;
      padding: 12px 16px;
      font-size: 16px;
      font-weight: 400;
      color: #222222;
      margin-bottom: 16px;
      outline-offset: 2px;
    }
    input::placeholder { color: #222222; }
    .error {
      color: red;
      font-size: 14px;
      margin-top: -10px;
      margin-bottom: 12px;
    }
    .password-info {
      font-size: 14px;
      color: #444444;
      margin: 0 0 8px 0;
    }
    ul.password-reqs {
      margin: 0 0 24px 20px;
      padding: 0;
      list-style-type: disc;
      color: #ff2a2a;
      font-size: 14px;
      line-height: 1.3;
    }
    .checkbox-container {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 24px;
    }
    .checkbox-container input[type="checkbox"] {
      margin-top: 3px;
      width: 18px;
      height: 18px;
      cursor: pointer;
    }
    .checkbox-container label {
      font-size: 14px;
      line-height: 1.4;
      color: #444444;
      user-select: none;
    }
    button.signup-btn {
      width: 100%;
      background-color: #1a1616;
      color: #f5e9db;
      font-weight: 600;
      font-size: 18px;
      padding: 14px 0;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button.signup-btn:hover,
    button.signup-btn:focus {
      background-color: #3a3535;
      outline: none;
    }
    .login-text {
      margin-top: 32px;
      font-weight: 700;
      font-size: 16px;
      text-align: center;
      color: #222222;
    }
    .login-text a {
      font-weight: 400;
      color: #222222;
      text-decoration: none;
      cursor: pointer;
    }
    .login-text a:hover,
    .login-text a:focus {
      text-decoration: underline;
      outline: none;
    }
    @media (max-width: 480px) {
      .modal {
        margin: 16px;
        padding: 24px 24px 32px 24px;
      }
      h2 {
        font-size: 18px;
        margin-bottom: 24px;
      }
      input[type="email"],
      input[type="password"] {
        font-size: 14px;
        padding: 10px 14px;
        margin-bottom: 20px;
      }
      .password-info,
      ul.password-reqs,
      .checkbox-container label {
        font-size: 13px;
      }
      button.signup-btn {
        font-size: 16px;
        padding: 12px 0;
      }
      .login-text {
        font-size: 14px;
        margin-top: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <button class="close-btn" aria-label="Close modal" onclick="window.location.href='{{ url('/') }}'">&times;</button>
    <h2 id="modalTitle">CREATE AN ACCOUNT</h2>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <input type="text" name="name" placeholder="Full Name*" value="{{ old('name') }}" required />
      @error('name')
        <div class="error">{{ $message }}</div>
      @enderror

      <!-- Username -->
      <input type="text" name="username" placeholder="Username*" value="{{ old('username') }}" required />
      @error('username')
        <div class="error">{{ $message }}</div>
      @enderror

      <!-- Email -->
      <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}" required />
      @error('email')
        <div class="error">{{ $message }}</div>
      @enderror

  <!-- Password -->
<div style="position: relative;">
  <input
    type="password"
    name="password"
    id="password"
    placeholder="Password*"
    required
    style="width: 100%; padding-right: 40px;"
  />
  <span
    onclick="togglePasswordVisibility()"
    style="
      position: absolute;
      right: 10px;
      top: 40%;
      transform: translateY(-50%);
      cursor: pointer;
    "
    id="togglePasswordIcon"
  >
    <!-- Eye icon (visible) -->
    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>

    <!-- Eye-off icon (hidden), hidden by default -->
    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
      width="24" height="24" style="display: none;">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.042 10.042 0 012.419-4.368m3.076-2.239A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-1.357 2.572M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l15-15" />
    </svg>
  </span>
</div>
@error('password')
  <div class="error" style="color: red;">{{ $message }}</div>
@enderror

     <p class="password-info">Your password must contain:</p>
        <ul class="password-reqs" id="password-requirements" aria-live="polite">
        <li id="req-length">8 karakter</li>
        <li id="req-number">1 angka</li>
        <li id="req-uppercase">Satu huruf besar dan satu huruf kecil</li>
        </ul>


      <!-- Confirm Password -->
<div style="position: relative;">
  <input
    type="password"
    name="password_confirmation"
    id="password_confirmation"
    placeholder="Confirm Password*"
    required
    style="width: 100%; padding-right: 40px;"
  />
  <span
    onclick="toggleConfirmPasswordVisibility()"
    style="
      position: absolute;
      right: 10px;
      top: 40%;
      transform: translateY(-50%);
      cursor: pointer;
    "
    id="toggleConfirmPasswordIcon"
  >
    <!-- Eye icon (visible) -->
    <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>

    <!-- Eye-off icon (hidden) -->
    <svg id="eyeClosedConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
      width="24" height="24" style="display: none;">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.042 10.042 0 012.419-4.368m3.076-2.239A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-1.357 2.572M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l15-15" />
    </svg>
  </span>
</div>

@error('password_confirmation')
  <div class="error" style="color: red;">{{ $message }}</div>
@enderror


      <!-- Agree to Terms -->
      <div class="checkbox-container">
        <input type="checkbox" id="agree" name="agree" required />
        <label for="agree">Dengan membuat akun, Anda menyetujui Kebijakan Privasi dan Ketentuan kami. Kami akan mengirimkan Anda informasi terbaru tentang semua hal tentang Toko Roti termasuk perasa, produk baru, dan penawaran khusus! Berhenti berlangganan kapan saja.</label>
      </div>

      <button type="submit" class="signup-btn">Sign Up</button>
    </form>

    <p class="login-text">
      <strong>Already have an account?</strong>
      <a href="{{ route('login') }}">Log in</a>
    </p>
  </div>
</body>
<script>
  const passwordInput = document.getElementById('password');

  const reqLength = document.getElementById('req-length');
  const reqNumber = document.getElementById('req-number');
  const reqUppercase = document.getElementById('req-uppercase');

  passwordInput.addEventListener('input', function () {
    const value = passwordInput.value;

    // Cek panjang
    if (value.length >= 8) {
      reqLength.style.color = 'green';
    } else {
      reqLength.style.color = 'red';
    }

    // Cek ada angka
    if (/\d/.test(value)) {
      reqNumber.style.color = 'green';
    } else {
      reqNumber.style.color = 'red';
    }

    // Cek huruf besar dan kecil
    if (/[a-z]/.test(value) && /[A-Z]/.test(value)) {
      reqUppercase.style.color = 'green';
    } else {
      reqUppercase.style.color = 'red';
    }
  });

  function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeOpen.style.display = "none";
      eyeClosed.style.display = "inline";
    } else {
      passwordInput.type = "password";
      eyeOpen.style.display = "inline";
      eyeClosed.style.display = "none";
    }
  }

  function toggleConfirmPasswordVisibility() {
    const passwordInput = document.getElementById("password_confirmation");
    const eyeOpen = document.getElementById("eyeOpenConfirm");
    const eyeClosed = document.getElementById("eyeClosedConfirm");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeOpen.style.display = "none";
      eyeClosed.style.display = "inline";
    } else {
      passwordInput.type = "password";
      eyeOpen.style.display = "inline";
      eyeClosed.style.display = "none";
    }
  }
</script>

</html>
