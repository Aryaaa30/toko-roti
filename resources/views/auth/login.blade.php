<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Modal</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: #222;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .modal {
      background: #fff;
      border-radius: 8px;
      width: 100%;
      max-width: 400px;
      padding: 32px 32px 40px 32px;
      position: relative;
    }
    .close-btn {
      position: absolute;
      top: 16px;
      right: 16px;
      font-size: 24px;
      font-weight: 700;
      color: #222;
      cursor: pointer;
      user-select: none;
      line-height: 1;
    }
    h2 {
      margin: 0 0 24px 0;
      font-weight: 700;
      font-size: 22px;
      text-align: center;
      color: #222;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      font-family: 'Roboto', sans-serif;
      font-size: 16px;
      padding: 12px 14px;
      border: 1.5px solid #222;
      border-radius: 6px;
      outline-offset: 2px;
      outline-color: transparent;
      transition: outline-color 0.2s ease;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      outline-color: #222;
    }
    button.login-btn {
      background-color: #1a1515;
      color: #f5d9c6;
      font-weight: 500;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      padding: 12px 0;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    button.login-btn:hover {
      background-color: #3a3232;
    }
    .forgot-password {
      margin-top: 12px;
      font-weight: 700;
      font-size: 14px;
      text-align: center;
      color: #222;
      cursor: pointer;
      user-select: none;
    }
    hr {
      margin: 32px 0 32px 0;
      border: none;
      border-top: 1px solid #ccc;
    }
    .signup-section {
      text-align: center;
    }
    .signup-section h2 {
      font-weight: 700;
      font-size: 22px;
      margin-bottom: 12px;
      color: #222;
    }
    .signup-section p {
      font-weight: 400;
      font-size: 16px;
      margin: 0 0 24px 0;
      color: #222;
    }
    button.create-account-btn {
      font-weight: 700;
      font-size: 16px;
      padding: 12px 0;
      width: 100%;
      border-radius: 6px;
      border: 1.5px solid #222;
      background: transparent;
      cursor: pointer;
      color: #222;
      transition: background-color 0.2s ease, color 0.2s ease;
    }
    button.create-account-btn:hover {
      background-color: #222;
      color: #fff;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-top: -15px;
    }
    .status-message {
      color: green;
      font-size: 14px;
      text-align: center;
      margin-bottom: 12px;
    }
    @media (max-width: 440px) {
      .modal {
        margin: 0 12px;
        padding: 24px 24px 32px 24px;
      }
    }
  </style>
</head>
<body>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <button class="close-btn" aria-label="Close login form">&times;</button>
    <h2 id="modalTitle">LOG IN</h2>

    @if (session('status'))
      <div class="status-message">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <input type="text" name="username" placeholder="Username*" required aria-required="true" value="{{ old('username') }}" />
      @error('username')
        <div class="error">{{ $message }}</div>
      @enderror

      <input type="password" name="password" placeholder="Password*" required aria-required="true" />
      @error('password')
        <div class="error">{{ $message }}</div>
      @enderror

      <label style="font-size: 14px; margin-top: -12px;">
        <input type="checkbox" name="remember" style="margin-right: 6px;"> Remember Me
      </label>

      <button type="submit" class="login-btn">Log in</button>
    </form>

    @if (Route::has('password.request'))
    <div class="forgot-password" tabindex="0">
      <a href="{{ route('password.request') }}" style="text-decoration: none; color: inherit;">Forgot your password?</a>
    </div>
    @endif

    <hr />
    <div class="signup-section">
      <h2>SIGN UP</h2>
      <p>Create an account to get access to order history, address book, and more!</p>
      <button class="create-account-btn" type="button" onclick="window.location.href='{{ route('register') }}'">Create Account</button>
    </div>
  </div>
  <script>
    document.querySelector('.close-btn').addEventListener('click', function() {
      window.history.back();
    });
  </script>
</body>
</html>
