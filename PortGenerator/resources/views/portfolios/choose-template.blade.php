<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Portfolio Template - PortGen</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/css/choose.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    @php
        $data = session('portfolio_data', []);
        $firstName = explode(' ',$data['full_name'] ?? 'AlexanderGabriel')[0];
    @endphp

    <div class="grid-container" aria-hidden="true">
        <div class="animated-grid"></div>
    </div>
    <canvas id="waveCanvas" aria-hidden="true"></canvas>

    <!-- Header Navigation Bar -->
    <header>
        <nav>
            <a href="{{ route('home') }}" class="logo">PortGen</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('portfolios.create') }}">Create Portfolio</a></li>
            </ul>
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
        </nav>
    </header>

    <main>
        <!-- Title Banner -->
        <div class="page-header">
            <h1>Choose Your Portfolio Template</h1>
            <p>Choose a design for <span>your portfolio</span>. You can edit your details anytime.</p>
        </div>

        <!-- Form for Template Selection -->
        <form id="templateForm" action="{{ route('portfolios.generate') }}" method="POST">
            @csrf
            <input type="hidden" name="template_id" id="selectedTemplateInput" value="{{ $templates->first()->id ?? '' }}">

            <div class="template-grid">
                @if(isset($templates) && count($templates) > 0)
                    @foreach($templates as $index => $template)
                        <div class="template-card {{ $loop->first ? 'selected' : '' }}" data-template-id="{{ $template->id }}">
                            
                            <!-- Clean Inner Portfolio Thumbnail Preview -->
                            <div class="mock-frame" style="padding: 0; overflow: hidden; background: #fff; position: relative; height: 260px; border-radius: 12px;">
                                <div class="mock-top-bar" style="position: absolute; top: 0; left: 0; right: 0; z-index: 10; background: rgba(18, 24, 41, 0.85); backdrop-filter: blur(4px); padding: 6px 10px;">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                                
                                <div style="width: 100%; height: 100%; overflow: hidden; position: relative;">
                                    <iframe 
                                        src="{{ route('portfolios.previewTemplate', $template->id) }}?from=template&is_thumbnail=1" 
                                        style="width: 1280px; height: 900px; transform: scale(0.24); transform-origin: 0 0; border: none; pointer-events: none; position: absolute; top: 24px; left: 0; scrolling: no;"
                                        scrolling="no">
                                    </iframe>
                                </div>
                            </div>

                            <!-- Card Text Information -->
                            <div>
                                <h3 class="template-title">{{ $template->name }}</h3>
                                <p class="template-desc">{{ $template->description }}</p>
                            </div>

                            <!-- Preview / Choose Buttons -->
                            <div class="card-actions">
                                <a href="{{ route('portfolios.previewTemplate', $template->id) }}?from=template" class="btn">Preview</a>
                                <button type="button" class="btn primary choose-btn" onclick="selectAndSubmit('{{ $template->id }}')">Choose</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="grid-column: 1 / -1; padding: 40px; text-align: center; border: 1px dashed var(--card-border); border-radius: 16px;">
                        <p style="font-size: 15px; font-weight: 700; color: var(--accent-blue);">No templates found in the database.</p>
                        <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Please insert template records in your Supabase database table.</p>
                    </div>
                @endif
            </div>
        </form>
        <!-- Back to Edit Link -->
        <a href="{{ isset($portfolio) && $portfolio->id ? route('portfolios.edit', $portfolio->id) : route('portfolios.create') }}" class="back-link">
            &larr; Back to Edit Portfolio
        </a>
    </main>

    <script>
        // Interactive Selection Logic
        function selectAndSubmit(templateId) {
            document.getElementById('selectedTemplateInput').value = templateId;
            document.getElementById('templateForm').submit();
        }

        document.querySelectorAll('.template-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
                document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                const id = this.getAttribute('data-template-id');
                document.getElementById('selectedTemplateInput').value = id;
            });
        });

        // Theme switching and persistence logic
        const html = document.documentElement;
        const themeButton = document.getElementById('themeToggleBtn');

        function setTheme(theme) {
            html.setAttribute('data-theme', theme);
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
        } catch (error) {}
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
</body>
</html>