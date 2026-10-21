<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortGen - Log in</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root[data-theme="dark"] {
            --bg-color: #0c0e12;
            --grid-line: rgba(255, 255, 255, 0.08);
            --text-main: #ffffff;
            --text-muted: #d1d5db;
            --accent-blue: #38bdf8;
            --accent-glow: rgba(56, 189, 248, 0.35);
            --nav-bg: rgba(12, 14, 18, 0.85);
            --nav-border: #38bdf8;
            --card-bg: rgba(18, 20, 26, 0.75);
            --card-border: rgba(56, 189, 248, 0.35);
        }

        :root[data-theme="light"] {
            --bg-color: #f8fafc;
            --grid-line: rgba(0, 0, 0, 0.08);
            --text-main: #0f172a;
            --text-muted: #475569;
            --accent-blue: #0284c7;
            --accent-glow: rgba(2, 132, 199, 0.25);
            --nav-bg: rgba(255, 255, 255, 0.9);
            --nav-border: #0284c7;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(2, 132, 199, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
            background: var(--bg-color);
            color: var(--text-main);
            font-family: 'Lora', serif;
        }

        .grid-container {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .animated-grid {
            position: absolute;
            width: 200%;
            height: 200%;
            left: -50%;
            top: -50%;
            background-image: linear-gradient(to right, var(--grid-line) 1px, transparent 1px),
                              linear-gradient(to bottom, var(--grid-line) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: scrollGrid 18s linear infinite;
        }

        @keyframes scrollGrid {
            to { transform: translate(48px, 48px); }
        }

        #waveCanvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        header, .main-content {
            position: relative;
            z-index: 2;
        }

        header {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 20px 0;
        }

        header > nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 12px 28px;
            border: 2px solid var(--nav-border);
            border-radius: 8px;
            background: var(--nav-bg);
            box-shadow: 0 0 15px var(--accent-glow);
            backdrop-filter: blur(12px);
        }

        .logo {
            color: var(--accent-blue);
            font-family: 'Sansation', sans-serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .back-home {
            color: var(--text-main);
            font-family: 'Sansation', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-home:hover {
            color: var(--accent-blue);
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 32px;
            border: 1.5px solid var(--card-border);
            border-radius: 20px;
            background: var(--card-bg);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3), 0 0 25px var(--accent-glow);
            backdrop-filter: blur(16px);
        }

        .eyebrow {
            text-align: center;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-family: 'Sansation', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--card-border);
            border-radius: 8px;
            background: var(--bg-color);
            color: var(--text-main);
            font-size: 14px;
            outline: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 10px var(--accent-glow);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            padding: 4px;
        }

        .toggle-password:hover {
            color: var(--accent-blue);
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
        }

        a.forgot-link {
            font-size: 12px;
            color: var(--text-muted);
            text-decoration: underline;
        }

        a.forgot-link:hover {
            color: var(--accent-blue);
        }

        .btn-submit {
            width: 100%;
            padding: 10px 22px;
            border: 1px solid var(--accent-blue);
            border-radius: 8px;
            background: var(--accent-blue);
            color: #07111a;
            font-family: 'Sansation', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--card-border);
        }

        .divider::before { margin-right: .75em; }
        .divider::after { margin-left: .75em; }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 11px;
            border: 1px solid var(--card-border);
            border-radius: 8px;
            background: var(--bg-color);
            color: var(--text-main);
            font-family: 'Sansation', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-google:hover {
            border-color: var(--accent-blue);
            box-shadow: 0 0 15px var(--accent-glow);
            transform: translateY(-2px);
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        .register-prompt {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--card-border);
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
        }

        .register-prompt a {
            color: var(--accent-blue);
            font-weight: 700;
            text-decoration: none;
        }

        .register-prompt a:hover {
            text-decoration: underline;
        }

        .error-msg {
            margin-top: 6px;
            font-size: 11px;
            color: #f87171;
        }
    </style>
</head>
<body>
    <div class="grid-container" aria-hidden="true">
        <div class="animated-grid"></div>
    </div>
    <canvas id="waveCanvas" aria-hidden="true"></canvas>

   <header>

        <nav>
            <a href="{{ url('/') }}" class="logo">PortGen</a>
            <a href="{{ url('/') }}" class="back-home">&larr; Back to Home</a>
        </nav>

    </header> 

    <div class="main-content">
        <div class="login-card">
            <div class="eyebrow">
                <span style="font-family: 'Sansation', sans-serif; font-size: 10px; font-weight: 700; letter-spacing: 2px; color: var(--accent-blue);">WELCOME BACK</span>
                <h2 style="font-family: 'Sansation', sans-serif; font-size: 22px; margin-top: 4px;">Log in to your account</h2>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" name="password" required autocomplete="current-password" />
                        <button type="button" id="togglePasswordBtn" class="toggle-password" aria-label="Toggle password visibility">
                            <svg id="eyeOpenIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg id="eyeClosedIcon" style="display: none;" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="checkbox-label" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember" style="accent-color: var(--accent-blue);" />
                        Remember me
                    </label>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-submit">Log in</button>
                </div>
            </form>

            <div class="divider">or</div>

            <a href="{{ route('auth.google') }}" class="btn-google">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.13 0-5.78-2.11-6.73-4.96H1.19v3.15C3.17 21.32 7.23 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.27 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.6H1.19C.43 8.13 0 9.87 0 12s.43 3.87 1.19 5.4l4.08-3.16z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.23 0 3.17 2.68 1.19 6.6l4.08 3.16c.95-2.85 3.6-4.96 6.73-4.96z"/>
                </svg>
                Continue with Google
            </a>

            @if (Route::has('register'))
                <div class="register-prompt">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeOpenIcon = document.getElementById('eyeOpenIcon');
        const eyeClosedIcon = document.getElementById('eyeClosedIcon');

        togglePasswordBtn.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeOpenIcon.style.display = type === 'text' ? 'none' : 'block';
            eyeClosedIcon.style.display = type === 'text' ? 'block' : 'none';
        });

        const html = document.documentElement;
        let savedTheme = 'dark';
        try { savedTheme = localStorage.getItem('portgen_theme') || 'dark'; } catch (error) {}
        html.setAttribute('data-theme', savedTheme);
    </script>
</body>
</html>