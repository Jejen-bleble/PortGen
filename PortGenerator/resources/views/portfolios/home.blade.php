<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PortGen</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="grid-container" aria-hidden="true">
        <div class="animated-grid"></div>
    </div>
    <canvas id="waveCanvas" aria-hidden="true"></canvas>

    <!-- Top Navigation Header -->
    <header>
        <nav>
            <div class="nav-left">
                <a href="{{ route('home') }}" class="logo">PortGen</a>
                <span class="badge">Dashboard</span>
            </div>

            <div class="nav-right">
                <span class="user-name" title="{{ auth()->user()->name }}">
                    {{ auth()->user()->name }}
                </span>

                <!-- Theme Toggle Button -->
               

                <!-- Settings Button -->
                <a href="{{ route('settings.edit') }}" class="button" style="padding: 6px 14px; font-size: 12px; min-height: 32px; display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                   <button type="button" class="button danger" onclick="openLogoutModal()" style="padding: 6px 14px; font-size: 12px; min-height: 32px; cursor: pointer;">
                        Log out
                    </button>
                </form>
                 <button id="themeToggleBtn" class="theme-toggle" aria-label="Toggle theme" title="Toggle theme">
                    <svg class="sun-icon" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main style="display: flex; flex-direction: column; gap: 32px;">

        <!-- Welcome Banner & Primary Action (Untouched layout) -->
        <div class="card welcome-card" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;">
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <h1 style="font-size: 28px; font-weight: 700;">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-muted" style="font-size: 15px; max-width: 600px; line-height: 1.6;">
                    Manage your active portfolio websites, track updates, or build a brand-new professional showcase in minutes.
                </p>
            </div>

            <div>
                <a href="{{ route('portfolios.create') ?? '#' }}" class="button primary">
                    <svg style="width: 16px; height: 16px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Portfolio
                </a>
            </div>
        </div>

        <!-- Quick Stats Overview -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="card" style="padding: 22px;">
                <p style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; color: var(--accent-blue); text-transform: uppercase;">Total Portfolios</p>
                <p style="font-family: 'Sansation', sans-serif; font-size: 32px; font-weight: 700; margin-top: 8px;">{{ $portfolios->count() ?? 0 }}</p>
            </div>
            <div class="card" style="padding: 22px;">
                <p style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; color: var(--accent-blue); text-transform: uppercase;">Active Account</p>
                <p style="font-size: 14px; font-weight: 600; margin-top: 12px; word-break: break-all;" class="text-muted">{{ auth()->user()->email }}</p>
            </div>
            <div class="card" style="padding: 22px;">
                <p style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; color: var(--accent-blue); text-transform: uppercase;">Account Status</p>
                <p style="font-size: 14px; font-weight: 600; margin-top: 12px; display: flex; align-items: center; gap: 8px; color: #34d399;">
                    <span style="width: 8px; height: 8px; background: #34d399; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #34d399;"></span> Active & Connected
                </p>
            </div>
        </div>

        <!-- Portfolios Grid Section -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <h2 style="font-size: 22px; font-weight: 700;">Your Portfolios</h2>

            @if(isset($portfolios) &&$portfolios->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                    @foreach($portfolios as $portfolio)
                        <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; gap: 20px;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <h3 style="font-size: 18px; font-weight: 700;">{{ $portfolio->full_name }}</h3>
                                    <span class="badge" style="font-size: 9px;">
                                        {{ $portfolio->template->name ?? 'Custom' }}
                                    </span>
                                </div>
                                <p style="font-size: 13px; font-weight: 600; color: var(--accent-blue);">
                                    {{ $portfolio->headline ?? 'Developer' }}
                                </p>
                                <p class="text-muted" style="font-size: 13px; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $portfolio->bio ?? 'No description provided.' }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <span style="font-size: 11px;" class="text-muted">Created {{ $portfolio->created_at->format('M d, Y') }}</span>
                                <div class="portfolio-actions">
                                    <a href="{{ url('/p/' . $portfolio->slug) }}" class="button" style="padding: 4px 10px; font-size: 11px; min-height: 28px;">View</a>
                                    <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="button primary" style="padding: 4px 10px; font-size: 11px; min-height: 28px;">Edit</a>
                                    
                                    <!-- Delete Button Form -->
                                    <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio?');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button danger" style="padding: 4px 10px; font-size: 11px; min-height: 28px; cursor: pointer;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card" style="text-align: center; padding: 50px 20px; display: flex; flex-direction: column; align-items: center; gap: 16px; border-style: dashed;">
                    <div style="width: 48px; height: 48px; background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--accent-blue);">
                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700;">No portfolios created yet</h3>
                        <p class="text-muted" style="font-size: 13px; margin-top: 4px;">Get started by creating your first portfolio showcase.</p>
                    </div>
                    <a href="{{ route('portfolios.create') ?? '#' }}" class="button primary" style="margin-top: 8px;">
                        Create Portfolio
                    </a>
                </div>
            @endif
        </div>

    </main>

    <script>
        const html = document.documentElement;
        const themeButton = document.getElementById('themeToggleBtn');

        function setTheme(theme) {
            html.setAttribute('data-theme', theme);
            if (themeButton) {
                const nextTheme = theme === 'dark' ? 'light' : 'dark';
                themeButton.setAttribute('aria-label', `Switch to ${nextTheme} mode`);
                themeButton.setAttribute('title', `Switch to ${nextTheme} mode`);
            }
            try { localStorage.setItem('portgen_theme', theme); } catch (error) {}
        }

        let savedTheme = 'dark';
        try { savedTheme = localStorage.getItem('portgen_theme') || 'dark'; } catch (error) {}
        setTheme(savedTheme);

        if (themeButton) {
            themeButton.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme');
                setTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });
        }

        const canvas = document.getElementById('waveCanvas');
        const context = canvas ? canvas.getContext('2d') : null;

        let waveWidth = 0;
        let waveHeight = 0;
        let waveTime = 0;
        let mouseX = window.innerWidth / 2;
        let mouseY = window.innerHeight / 2;
        let targetX = mouseX;
        let targetY = mouseY;

        function resizeCanvas() {
            if (!canvas || !context) return;
            const pixelRatio = window.devicePixelRatio || 1;
            waveWidth = window.innerWidth;
            waveHeight = window.innerHeight;
            canvas.width = Math.floor(waveWidth * pixelRatio);
            canvas.height = Math.floor(waveHeight * pixelRatio);
            canvas.style.width = `${waveWidth}px`;
            canvas.style.height = `${waveHeight}px`;
            context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
        }

        function drawWaves() {
            if (!canvas || !context) return;
            mouseX += (targetX - mouseX) * 0.025;
            mouseY += (targetY - mouseY) * 0.025;
            context.clearRect(0, 0, waveWidth, waveHeight);

            const isLight = html.getAttribute('data-theme') === 'light';
            const waveColor = isLight ? '2, 132, 199' : '56, 189, 248';
            const lineCount = 30;

            for (let line = 0; line < lineCount; line++) {
                context.beginPath();
                context.lineWidth = line === 15 ? 2.2 : 1.25;
                context.strokeStyle = `rgba(${waveColor}, ${0.32 + (line / lineCount) * 0.48})`;
                const baseY = waveHeight * 0.48 + (line - lineCount / 2) * 10;

                for (let x = 0; x <= waveWidth; x += 3) {
                    const mouseInfluence = Math.sin((x - mouseX) * 0.002) * ((mouseY - waveHeight / 2) * 0.06);
                    const y = baseY + Math.sin(x * 0.0025 + waveTime + line * 0.12) * 105
                                  + Math.sin(x * 0.0015 - waveTime * 0.7) * 55
                                  + mouseInfluence;
                    if (x === 0) context.moveTo(x, y);
                    else context.lineTo(x, y);
                }
                context.stroke();
            }

            waveTime += 0.012;
            window.requestAnimationFrame(drawWaves);
        }

        window.addEventListener('resize', resizeCanvas);
        window.addEventListener('mousemove', event => {
            targetX = event.clientX;
            targetY = event.clientY;
        });

        resizeCanvas();
        drawWaves();
    </script>

    <!-- Logout Confirmation Modal Backdrop & Container -->
    <div id="logoutModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
        <div class="card" style="width: 100%; max-width: 400px; padding: 28px; display: flex; flex-direction: column; gap: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid var(--card-border, rgba(56, 189, 248, 0.3)); background: var(--card-bg, #12141a);">
            <div style="display: flex; flex-direction: column; gap: 8px; text-align: center;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-main, #ffffff);">Are you sure you want to log out?</h3>
                <p class="text-muted" style="font-size: 14px;">You will need to sign back in to access your portfolios and dashboard.</p>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: center; margin-top: 4px;">
                <button type="button" onclick="closeLogoutModal()" class="button" style="flex: 1; padding: 10px; justify-content: center;">No</button>
                
                <!-- Actual Form That Submits Logout -->
                <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" class="button danger" style="width: 100%; padding: 10px; justify-content: center;">Yes</button>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
        <div class="card" style="width: 100%; max-width: 400px; padding: 28px; display: flex; flex-direction: column; gap: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid var(--card-border, rgba(56, 189, 248, 0.3)); background: var(--card-bg, #12141a);">
            <div style="display: flex; flex-direction: column; gap: 8px; text-align: center;">
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-main, #ffffff);">Delete Portfolio?</h3>
                <p class="text-muted" style="font-size: 14px;">Are you sure you want to delete <span id="deletePortfolioName" style="color: var(--text-main); font-weight: 600;"></span>? This action cannot be undone.</p>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: center; margin-top: 4px;">
                <button type="button" onclick="closeDeleteModal()" class="button" style="flex: 1; padding: 10px; justify-content: center;">Cancel</button>
                
                <form id="deleteForm" method="POST" action="" style="flex: 1; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger" style="width: 100%; padding: 10px; justify-content: center;">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
    <script>
                function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Optional: Close modal if user clicks outside the modal box
        window.addEventListener('click', (event) => {
            const modal = document.getElementById('logoutModal');
            if (event.target === modal) {
                closeLogoutModal();
            }
        });

        function openDeleteModal(deleteUrl, portfolioName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const nameSpan = document.getElementById('deletePortfolioName');
            
            if (form && modal) {
                form.action = deleteUrl;
                nameSpan.textContent = `"${portfolioName}"`;
                modal.style.display = 'flex';
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

    // Close modals when clicking outside the container box
        window.addEventListener('click', (event) => {
        const logoutModal = document.getElementById('logoutModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target === logoutModal) {
            closeLogoutModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
    </script>

    @if(session('success'))
        <div id="successPopupModal" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div class="card" style="width: 100%; max-width: 400px; padding: 32px; display: flex; flex-direction: column; gap: 20px; box-shadow: 0 0 30px rgba(56, 189, 248, 0.25); border: 2px solid #38bdf8; background: var(--card-bg, #12141a); border-radius: 16px; text-align: center;">
                
                <!-- Icon & Message -->
                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; background: rgba(52, 211, 153, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #34d399;">
                        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 style="font-family: 'Sansation', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-main, #ffffff);">Success!</h3>
                    <p class="text-muted" style="font-size: 14px; line-height: 1.5;">{{ session('success') }}</p>
                </div>
                
                <!-- Action Button -->
                <button type="button" onclick="closeSuccessPopup()" class="button primary" style="width: 100%; padding: 12px; justify-content: center; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer;">
                    Okay
                </button>
            </div>
        </div>

        <script>
            function closeSuccessPopup() {
                const modal = document.getElementById('successPopupModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }
        </script>
    @endif
</body>
</html>