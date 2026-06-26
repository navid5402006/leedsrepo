<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Leeds Academy · Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: #F5F7FA;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .login-wrapper {
      display: flex;
      flex-wrap: wrap;
      max-width: 1280px;
      width: 100%;
      background: #FFFFFF;
      border-radius: 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      transition: all 0.2s ease;
    }

    .brand-side {
      flex: 1 1 55%;
      background: linear-gradient(145deg, #071B3B 0%, #0a2547 100%);
      padding: 48px 40px 40px 40px;
      display: flex;
      flex-direction: column;
      position: relative;
      min-height: 600px;
      color: white;
    }

    .brand-side::after {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 20% 30%, rgba(109, 74, 255, 0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .brand-content {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 48px;
    }

    .logo-icon {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(2px);
      width: 44px;
      height: 44px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: #6D4AFF;
      box-shadow: 0 6px 12px -6px rgba(0,0,0,0.3);
    }

    .logo-text {
      font-weight: 700;
      font-size: 22px;
      letter-spacing: -0.3px;
      color: white;
    }

    .logo-text span {
      color: #6D4AFF;
    }

    .brand-headline {
      margin-top: 12px;
      margin-bottom: 16px;
    }

    .brand-headline h1 {
      font-size: 38px;
      font-weight: 700;
      line-height: 1.2;
      letter-spacing: -0.02em;
      color: white;
      max-width: 500px;
    }

    .brand-headline .sub {
      font-size: 18px;
      font-weight: 400;
      color: rgba(255, 255, 255, 0.7);
      margin-top: 12px;
      max-width: 440px;
      line-height: 1.5;
    }

    .illustration-area {
      margin-top: 40px;
      flex: 1;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      opacity: 0.85;
    }

    .illustration-svg {
      max-width: 100%;
      height: auto;
      filter: drop-shadow(0 8px 24px rgba(0,0,0,0.25));
    }

    .login-side {
      flex: 1 1 45%;
      background: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 32px;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      margin: 0 auto;
    }

    .login-card .welcome {
      margin-bottom: 32px;
    }

    .login-card .welcome h2 {
      font-size: 28px;
      font-weight: 600;
      color: #1E293B;
      letter-spacing: -0.02em;
      margin-bottom: 6px;
    }

    .login-card .welcome p {
      color: #64748B;
      font-size: 15px;
      font-weight: 400;
    }

    /* Error messages */
    .alert-danger {
      background: #FEE2E2;
      border: 1px solid #FECACA;
      color: #DC2626;
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-danger i {
      font-size: 16px;
    }

    .alert-danger ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .alert-danger ul li {
      margin-bottom: 2px;
    }

    .alert-success {
      background: #DCFCE7;
      border: 1px solid #BBF7D0;
      color: #10B981;
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      font-size: 16px;
      transition: color 0.2s;
      pointer-events: none;
    }

    .input-group input {
      width: 100%;
      padding: 14px 16px 14px 46px;
      border: 1.5px solid #E2E8F0;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      background: #FFFFFF;
      color: #1E293B;
      transition: all 0.2s ease;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .input-group input:focus {
      outline: none;
      border-color: #6D4AFF;
      box-shadow: 0 0 0 4px rgba(109, 74, 255, 0.12), 0 1px 3px rgba(0,0,0,0.02);
    }

    .input-group input.is-invalid {
      border-color: #DC2626;
      box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
    }

    .input-group input::placeholder {
      color: #94A3B8;
      font-weight: 400;
      font-size: 14px;
    }

    .input-group .toggle-password {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      color: #94A3B8;
      cursor: pointer;
      font-size: 16px;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s;
    }

    .input-group .toggle-password:hover {
      color: #475569;
    }

    .login-extras {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 24px 0 28px 0;
      flex-wrap: wrap;
      gap: 12px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      color: #334155;
      font-weight: 500;
      cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
      appearance: none;
      width: 18px;
      height: 18px;
      border: 2px solid #CBD5E1;
      border-radius: 6px;
      background: white;
      cursor: pointer;
      transition: all 0.15s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .remember-me input[type="checkbox"]:checked {
      background: #6D4AFF;
      border-color: #6D4AFF;
      box-shadow: 0 0 0 2px rgba(109, 74, 255, 0.2);
    }

    .remember-me input[type="checkbox"]:checked::after {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 12px;
      color: white;
    }

    .forgot-link {
      font-size: 14px;
      font-weight: 500;
      color: #6D4AFF;
      text-decoration: none;
      transition: color 0.2s;
    }

    .forgot-link:hover {
      color: #4f33cc;
      text-decoration: underline;
    }

    .login-btn {
      width: 100%;
      padding: 16px 20px;
      background: linear-gradient(135deg, #6D4AFF 0%, #5533cc 100%);
      border: none;
      border-radius: 12px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.2px;
      box-shadow: 0 8px 18px -8px rgba(109, 74, 255, 0.35);
      transition: all 0.2s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .login-btn i {
      font-size: 18px;
      transition: transform 0.2s;
    }

    .login-btn:hover {
      background: linear-gradient(135deg, #7a5aff 0%, #4a2fbb 100%);
      box-shadow: 0 12px 24px -10px rgba(109, 74, 255, 0.45);
      transform: translateY(-2px);
    }

    .login-btn:active {
      transform: translateY(0px);
      box-shadow: 0 4px 12px -6px rgba(109, 74, 255, 0.4);
    }

    .login-footer {
      margin-top: 32px;
      text-align: center;
      font-size: 14px;
      color: #94A3B8;
      letter-spacing: 0.2px;
      font-weight: 400;
      border-top: 1px solid #F1F5F9;
      padding-top: 24px;
    }

    @media (max-width: 920px) {
      .brand-side {
        flex: 1 1 100%;
        min-height: 300px;
        padding: 32px 28px;
      }
      .brand-headline h1 {
        font-size: 30px;
      }
      .illustration-area {
        margin-top: 20px;
      }
      .login-side {
        flex: 1 1 100%;
        padding: 32px 20px;
      }
      .login-card {
        max-width: 400px;
      }
    }

    @media (max-width: 480px) {
      .login-wrapper {
        border-radius: 24px;
      }
      .brand-side {
        padding: 24px 20px;
        min-height: 220px;
      }
      .brand-headline h1 {
        font-size: 24px;
      }
      .brand-headline .sub {
        font-size: 15px;
      }
      .login-card .welcome h2 {
        font-size: 24px;
      }
      .login-extras {
        flex-direction: column;
        align-items: flex-start;
      }
      .login-btn {
        padding: 14px;
      }
    }

    .login-card {
      background: transparent;
    }

    .input-group input[type="email"],
    .input-group input[type="password"] {
      padding-left: 46px;
    }

    .login-side {
      background: #FFFFFF;
    }

    .brand-side .logo-area .logo-icon {
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(4px);
    }

    /* Field error text */
    .field-error {
      color: #DC2626;
      font-size: 13px;
      margin-top: 4px;
      display: block;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <!-- LEFT: Branding -->
    <div class="brand-side">
      <div class="brand-content">
        <div class="logo-area">
          <div class="logo-icon">
            <i class="fas fa-graduation-cap"></i>
          </div>
          <div class="logo-text">Leeds<span>Academy</span></div>
        </div>

        <div class="brand-headline">
          <h1>Leeds Academy<br />Management System</h1>
          <div class="sub">
            Manage Students, Courses, Fees, Certificates and Reports
          </div>
        </div>

        <div class="illustration-area">
          <svg class="illustration-svg" width="320" height="180" viewBox="0 0 320 180" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="40" width="60" height="80" rx="8" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" />
            <rect x="100" y="20" width="60" height="100" rx="8" fill="rgba(255,255,255,0.07)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" />
            <rect x="180" y="50" width="60" height="70" rx="8" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.08)" stroke-width="1.5" />
            <rect x="260" y="30" width="40" height="90" rx="8" fill="rgba(109,74,255,0.15)" stroke="rgba(109,74,255,0.2)" stroke-width="1.5" />
            <circle cx="50" cy="140" r="12" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.06)" stroke-width="1" />
            <circle cx="140" cy="140" r="12" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.06)" stroke-width="1" />
            <circle cx="230" cy="140" r="12" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.06)" stroke-width="1" />
            <path d="M40 130 L60 110 L80 130 L100 110 L120 130 L140 110 L160 130 L180 110 L200 130 L220 110 L240 130 L260 110 L280 130" stroke="rgba(109,74,255,0.3)" stroke-width="2" stroke-linecap="round" />
            <rect x="38" y="108" width="14" height="14" rx="4" fill="#6D4AFF" opacity="0.3" />
            <rect x="118" y="108" width="14" height="14" rx="4" fill="#6D4AFF" opacity="0.2" />
            <rect x="198" y="108" width="14" height="14" rx="4" fill="#6D4AFF" opacity="0.25" />
            <circle cx="260" cy="80" r="6" fill="#6D4AFF" opacity="0.5" />
          </svg>
        </div>
      </div>
    </div>

    <!-- RIGHT: Login card -->
    <div class="login-side">
      <div class="login-card">
        <div class="welcome">
          <h2>Welcome Back</h2>
          <p>Sign in to your account to continue</p>
        </div>

        {{-- Display success messages --}}
        @if(session('success'))
          <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
          </div>
        @endif

        {{-- Display validation errors --}}
        @if($errors->any())
          <div class="alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <!-- Email -->
          <div class="input-group">
            <span class="input-icon"><i class="fas fa-envelope"></i></span>
            <input type="email" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required autofocus />
          </div>
          @error('email')
            <span class="field-error">{{ $message }}</span>
          @enderror

          <!-- Password -->
          <div class="input-group">
            <span class="input-icon"><i class="fas fa-lock"></i></span>
            <input type="password" id="password" name="password" placeholder="Password" class="@error('password') is-invalid @enderror" required />
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
              <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
          </div>
          @error('password')
            <span class="field-error">{{ $message }}</span>
          @enderror

          <!-- extras -->
          <div class="login-extras">
            <label class="remember-me">
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} /> Remember me
            </label>
            <a href="#" class="forgot-link">Forgot password?</a>
          </div>

          <!-- Login button -->
          <button type="submit" class="login-btn">
            <span>Sign in</span>
            <i class="fas fa-arrow-right"></i>
          </button>
        </form>

        <div class="login-footer">
          &copy; Leeds Academy
        </div>
      </div>
    </div>
  </div>

  <!-- toggle password visibility -->
  <script>
    (function() {
      const toggleBtn = document.getElementById('togglePassword');
      const passwordField = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');

      if (toggleBtn && passwordField) {
        toggleBtn.addEventListener('click', function() {
          const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordField.setAttribute('type', type);
          if (toggleIcon) {
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
          }
        });
      }
    })();
  </script>
</body>
</html>