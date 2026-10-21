<!DOCTYPE html>
<html lang="en" data-theme="dark" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio - PortGen</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/css/edit.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="grid-container" aria-hidden="true">
        <div class="animated-grid"></div>
    </div>
    <canvas id="waveCanvas" aria-hidden="true"></canvas>

    <!-- Top Navigation Bar -->
    <header>
        <nav>
            <div class="nav-left">
                <a href="{{ route('home') }}" class="logo">PortGen</a>
                <span class="badge">Edit Portfolio</span>
            </div>

            <div class="nav-right">
                <a href="{{ route('home') }}" class="button" style="padding: 6px 14px; font-size: 12px; min-height: 32px;">Dashboard</a>
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

    <!-- Main Content Layout -->
    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid var(--card-border); padding-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 700;">Edit Portfolio</h1>
                <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Update your personal details, professional background, and links below.</p>
            </div>
        </div>

        @if ($errors->any())
            <div style="background: rgba(248, 113, 113, 0.15); border-left: 4px solid #f87171; padding: 16px; border-radius: 8px; color: #fca5a5; font-size: 13px; margin-bottom: 24px;">
                <p style="font-weight: 700;">Please fix the following errors:</p>
                <ul style="padding-left: 20px; margin-top: 6px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 1. Personal Details -->
            <section class="card-section">
                <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 20px;">
                    <h2 style="font-size: 17px; font-weight: 700;">Personal details</h2>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">How visitors will recognize and reach you.</p>
                </div>

                <!-- Profile Picture Upload -->
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
                    <div style="width: 64px; height: 64px; border-radius: 14px; background: var(--input-bg); border: 1px solid var(--card-border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); overflow: hidden; flex-shrink: 0;">
                        @if($portfolio->profile_image)
                            <img src="{{ asset('storage/' . $portfolio->profile_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; margin-bottom: 4px;">Change profile picture</p>
                        <input type="file" name="profile_image" accept="image/*" style="font-size: 12px; color: var(--text-muted);">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label>Full name <span style="color: var(--accent-blue);">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $portfolio->full_name) }}" required placeholder="e.g., Alex Manigos">
                    </div>
                    <div>
                        <label>Professional Headline <span style="color: var(--accent-blue);">*</span></label>
                        <input type="text" name="headline" value="{{ old('headline', $portfolio->headline) }}" required placeholder="e.g., Full-Stack Developer">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $portfolio->email) }}" placeholder="alex@email.com">
                    </div>
                    <div>
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number', $portfolio->contact_number) }}" placeholder="e.g., +63 912 345 6789">
                    </div>
                </div>

                <div>
                    <label>Address / Location</label>
                    <input type="text" name="address" value="{{ old('address', $portfolio->address) }}" placeholder="e.g., Cebu City, Philippines">
                </div>
            </section>

            <!-- 2. About Me / Bio -->
            <section class="card-section">
                <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 16px;">
                    <h2 style="font-size: 17px; font-weight: 700;">About me</h2>
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">A short introduction in your own words.</p>
                </div>
                <div>
                    <textarea name="bio" rows="4" placeholder="Tell visitors who you are, what you do...">{{ old('bio', $portfolio->bio) }}</textarea>
                </div>
            </section>

            <!-- 3. Educational Background -->
            <section class="card-section">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h2 style="font-size: 17px; font-weight: 700;">Educational background</h2>
                        <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Add every school or program you want to show.</p>
                    </div>
                    <button type="button" onclick="addEducation()" class="button secondary">+ Add education</button>
                </div>

                <div id="education-container" style="display: flex; flex-direction: column; gap: 14px;">
                    @php
                        $educations = old('education');
                        if (!$educations && isset($portfolio)) {
                            $educations =$portfolio->sections->where('section_type', 'education')->map(fn($s) =>$s->content)->toArray();
                        }
                        if (empty($educations)) {$educations = [['school' => '', 'degree' => '', 'year' => '']]; }
                    @endphp

                    @foreach($educations as $index =>$edu)
                        <div class="sub-item-box education-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--card-border); padding-bottom: 8px;">
                                <span style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; color: var(--accent-blue);">Education {{ $index + 1 }}</span>
                                @if($index > 0)
                                    <button type="button" onclick="this.closest('.education-item').remove()" class="button danger">Remove</button>
                                @endif
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label>School or university <span style="color: var(--accent-blue);">*</span></label>
                                <input type="text" name="education[{{ $index }}][school]" value="{{ $edu['school'] ?? '' }}" placeholder="e.g., Cebu Eastern College" required>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                                <div>
                                    <label>Degree or program <span style="color: var(--accent-blue);">*</span></label>
                                    <input type="text" name="education[{{ $index }}][degree]" value="{{ $edu['degree'] ?? '' }}" placeholder="e.g., BS Information Technology" required>
                                </div>
                                <div>
                                    <label>Years <span style="color: var(--accent-blue);">*</span></label>
                                    <input type="text" name="education[{{ $index }}][year]" value="{{ $edu['year'] ?? '' }}" placeholder="e.g., 2024 - 2028" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- 4. Projects Section -->
            <section class="card-section">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h2 style="font-size: 17px; font-weight: 700;">Projects</h2>
                        <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Show your best work.</p>
                    </div>
                    <button type="button" onclick="addProject()" class="button secondary">+ Add project</button>
                </div>

                <div id="project-container" style="display: flex; flex-direction: column; gap: 14px;">
                    @php
                        $projs = old('projects');
                        if (!$projs && isset($portfolio)) {
                            $projs =$portfolio->sections->where('section_type', 'projects')->map(fn($s) =>$s->content)->toArray();
                        }
                        if (empty($projs)) {$projs = [['title' => '', 'link' => '', 'description' => '']]; }
                    @endphp

                    @foreach($projs as $index =>$proj)
                        <div class="sub-item-box project-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--card-border); padding-bottom: 8px;">
                                <span style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; color: var(--accent-blue);">Project {{ $index + 1 }}</span>
                                @if($index > 0)
                                    <button type="button" onclick="this.closest('.project-item').remove()" class="button danger">Remove</button>
                                @endif
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 12px;">
                                <div>
                                    <label>Project title</label>
                                    <input type="text" name="projects[{{ $index }}][title]" value="{{ $proj['title'] ?? '' }}" placeholder="e.g., PortGen">
                                </div>
                                <div>
                                    <label>Link <span style="font-weight: 400; text-transform: none; color: var(--text-muted);">(optional)</span></label>
                                    <input type="text" name="projects[{{ $index }}][link]" value="{{ $proj['link'] ?? '' }}" placeholder="https:// or leave blank">
                                </div>
                            </div>
                            <div>
                                <label>Description</label>
                                <textarea name="projects[{{ $index }}][description]" rows="3" placeholder="What did you build, and what was your part?">{{ $proj['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- 5. Work Experience Section -->
            <section class="card-section">
                <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 16px;">
                    <h2 style="font-size: 17px; font-weight: 700;">Work Experience</h2>
                </div>
                <div>
                    <label>Experience / Background Summary</label>
                    <textarea name="experience" rows="4" placeholder="e.g., Freelance Web Developer (2025 - Present)...">{{ old('experience', $portfolio->experience) }}</textarea>
                </div>
            </section>

            <!-- 6. Social Media Links Section -->
            <section class="card-section">
                <div style="border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 16px;">
                    <h2 style="font-size: 17px; font-weight: 700;">Social Media Links</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                    <div>
                        <label>GitHub URL</label>
                        <input type="text" name="github" value="{{ old('github', $portfolio->github) }}" placeholder="https://github.com/username">
                    </div>
                    <div>
                        <label>LinkedIn URL</label>
                        <input type="text" name="linkedin" value="{{ old('linkedin', $portfolio->linkedin) }}" placeholder="https://linkedin.com/in/username">
                    </div>
                    <div>
                        <label>Twitter / X URL</label>
                        <input type="text" name="twitter" value="{{ old('twitter', $portfolio->twitter) }}" placeholder="https://twitter.com/username">
                    </div>
                    <div>
                        <label>Facebook URL</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $portfolio->facebook) }}" placeholder="https://facebook.com/username">
                    </div>
                </div>
            </section>

            <!-- Dynamic Scripts -->
            <script>
                let eduIndex = {{ count($educations) > 0 ? count($educations) - 1 : 0 }};
                function addEducation() {
                    eduIndex++;
                    const container = document.getElementById('education-container');
                    const html = `
                        <div class="sub-item-box education-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--card-border); padding-bottom: 8px;">
                                <span style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; color: var(--accent-blue);">Education</span>
                                <button type="button" onclick="this.closest('.education-item').remove()" class="button danger">Remove</button>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label>School or university *</label>
                                <input type="text" name="education[${eduIndex}][school]" placeholder="e.g., School Name" required>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                                <div>
                                    <label>Degree or program *</label>
                                    <input type="text" name="education[${eduIndex}][degree]" placeholder="e.g., Degree / Strand" required>
                                </div>
                                <div>
                                    <label>Years *</label>
                                    <input type="text" name="education[${eduIndex}][year]" placeholder="e.g., 2024 - 2028" required>
                                </div>
                            </div>
                        </div>`;
                    container.insertAdjacentHTML('beforeend', html);
                }

                let projIndex = {{ count($projs) > 0 ? count($projs) - 1 : 0 }};
                function addProject() {
                    projIndex++;
                    const container = document.getElementById('project-container');
                    const html = `
                        <div class="sub-item-box project-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid var(--card-border); padding-bottom: 8px;">
                                <span style="font-family: 'Sansation', sans-serif; font-size: 11px; font-weight: 700; color: var(--accent-blue);">Project</span>
                                <button type="button" onclick="this.closest('.project-item').remove()" class="button danger">Remove</button>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 12px;">
                                <div>
                                    <label>Project title</label>
                                    <input type="text" name="projects[${projIndex}][title]" placeholder="e.g., Project Name">
                                </div>
                                <div>
                                    <label>Link (optional)</label>
                                    <input type="text" name="projects[${projIndex}][link]" placeholder="https:// or leave blank">
                                </div>
                            </div>
                            <div>
                                <label>Description</label>
                                <textarea name="projects[${projIndex}][description]" rows="3" placeholder="What did you build, and what was your part?"></textarea>
                            </div>
                        </div>`;
                    container.insertAdjacentHTML('beforeend', html);
                }
            </script>

            <!-- Submit Button Bar -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 10px; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('home') }}" class="button">Cancel</a>
                <button type="submit" class="button primary">
                    <span>Update Portfolio &rarr;</span>
                </button>
            </div>
        </form>
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
</body>
</html>