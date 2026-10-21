<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortGen - Online Portfolio Template Generator</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link rel="stylesheet" href="/css/welcome.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="grid-container" aria-hidden="true">
        <div class="animated-grid"></div>
    </div>
    <canvas id="waveCanvas" aria-hidden="true"></canvas>

    <header>
       <nav>
            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">PortGen</a>
            
            <!-- Left/Center Nav Links (Only Home remains here) -->
            <ul class="nav-links">
                <li><a href="#hero">Home</a></li>
            </ul>

            <!-- Right Actions Group: Log in/Dashboard, Theme Toggle, and Get Started -->
            <div style="display: flex; align-items: center; gap: 12px;">

                <!-- Primary Action Button -->
                @auth

                    <a class="button primary" href="{{ route('home') }}" style="min-height: 38px; padding: 6px 16px; font-size: 13px;">Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" style="color: #cbd5e1; text-decoration: none; font-weight: 500; font-size: 14px;">Log in</a>
                    <a class="button primary" href="{{ route('register') }}" style="min-height: 38px; padding: 6px 16px; font-size: 13px;">Get Started</a>
                @endauth

                  <button id="themeToggleBtn" class="theme-toggle" aria-label="Toggle theme" title="Toggle theme">
                        <!-- Sun Icon -->
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
                        <!-- Moon Icon -->
                        <svg class="moon-icon" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>
            </div>
            
        </nav>
    </header>

    <main id="hero">
        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">YOUR PORTFOLIO, YOUR STYLE</span>
                <h1>Build a portfolio that <span>shows who you are.</span></h1>
                <p class="hero-copy">
                    Create your own online portfolio without starting from scratch. Add your information,
                    choose a design, and share your work through a public portfolio link.
                </p>
                <div class="hero-actions">
                    @auth
                        <a class="button primary" href="{{ route('home') }}">Open Your Dashboard <span aria-hidden="true">&nbsp;→</span></a>
                    @else
                        <a class="button primary" href="{{ route('register') }}">Create My Portfolio <span aria-hidden="true">&nbsp;→</span></a>
                        <a class="button" href="{{ route('login') }}">Log in</a>
                    @endauth
                    <a class="button" href="#how-it-works">How It Works</a>
                </div>
            </div>

            <div class="hero-card" aria-label="Portfolio design preview">
                <div class="mock-window">
                    <div class="mock-top">
                        <span class="mock-dot"></span>
                        <span class="mock-dot"></span>
                        <span class="mock-dot"></span>
                    </div>
                    <div class="mock-content">
                        <p class="mock-label">PERSONAL PORTFOLIO</p>
                        <div class="mock-name">Your Name</div>
                        <p style="color: var(--text-muted); font-size: 13px; line-height: 1.7;">Showcase your skills, projects, education, and experience in one place.</p>
                        <div class="mock-line"></div>
                        <div class="mock-line medium"></div>
                        <div class="mock-line short"></div>
                        <div class="mock-tags">
                            <span>About Me</span>
                            <span>Projects</span>
                            <span>Skills</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="how-it-works">
            <div class="section-heading">
                <p>Simple steps</p>
                <h2>How It Works</h2>
                <div class="muted">Make your portfolio in three simple steps.</div>
            </div>

            <div class="steps">
                <article class="step-card">
                    <div class="step-number">01</div>
                    <h3>Add Your Details</h3>
                    <p>Enter your personal information, education, skills, projects, work experience, and links.</p>
                </article>

                <article class="step-card">
                    <div class="step-number">02</div>
                    <h3>Choose a Template</h3>
                    <p>Pick from three portfolio designs and use the style that best fits your personality and work.</p>
                </article>

                <article class="step-card">
                    <div class="step-number">03</div>
                    <h3>Share Your Portfolio</h3>
                    <p>Preview your portfolio and share its public link with classmates, employers, or clients.</p>
                </article>
            </div>

            <div class="bottom-cta">
                <h2>Ready to create your portfolio?</h2>
                <p>Start with your details and turn them into a portfolio you can share online.</p>
                @auth
                    <a class="button primary" href="{{ route('home') }}">Go to Dashboard <span aria-hidden="true">&nbsp;→</span></a>
                @else
                    <a class="button primary" href="{{ route('register') }}">Get Started <span aria-hidden="true">&nbsp;→</span></a>
                @endauth
            </div>
        </section>
    </main>

    <footer>© {{ date('Y') }} PortGen. Create a portfolio that represents you.</footer>

    <script>
        // Handle theme switching and persistence
        const html = document.documentElement;
        const themeButton = document.getElementById('themeToggleBtn');

        function setTheme(theme) {
            html.setAttribute('data-theme', theme);
            document.body.setAttribute('data-theme', theme);
            html.classList.toggle('dark', theme === 'dark');
            html.classList.toggle('light', theme === 'light');

            if (themeButton) {
                const nextTheme = theme === 'dark' ? 'light' : 'dark';
                themeButton.setAttribute('aria-label', `Switch to ${nextTheme} mode`);
                themeButton.setAttribute('title', `Switch to ${nextTheme} mode`);
            }

            try {
                localStorage.setItem('portgen_theme', theme);
            } catch (error) {}
        }

        let savedTheme = 'dark';
        try {
            savedTheme = localStorage.getItem('portgen_theme') || 'dark';
        } catch (error) {
            savedTheme = 'dark';
        }
        setTheme(savedTheme);

        if (themeButton) {
            themeButton.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme');
                setTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });
        }

        // Animated canvas wave background
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
                    const mouseInfluence = Math.sin((x - mouseX) * 0.002)
                        * ((mouseY - waveHeight / 2) * 0.06);
                    const y = baseY
                        + Math.sin(x * 0.0025 + waveTime + line * 0.12) * 105
                        + Math.sin(x * 0.0015 - waveTime * 0.7) * 55
                        + mouseInfluence;

                    if (x === 0) {
                        context.moveTo(x, y);
                    } else {
                        context.lineTo(x, y);
                    }
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
</body>
</html>