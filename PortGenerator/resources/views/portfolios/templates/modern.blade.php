@php
    $name =$portfolio->full_name ?: 'Your Name';
    $headline =$portfolio->headline ?: 'Developer / Professional';
    $about =$portfolio->bio ?: 'A snapshot of my work, experience, and the things I love creating.';
    $email =$portfolio->email ?? '';
    $phone =$portfolio->contact_number ?? '';
    $location =$portfolio->address ?? '';
    $photo =$portfolio->profile_image
        ? asset('storage/' . $portfolio->profile_image)
        : null;

    $groupedSections = $portfolio->sections ? $portfolio->sections->groupBy('section_type') : collect();

    // Social links array
    $socials = [];
    if (!empty($portfolio->github)) $socials[] = ['label' => 'GitHub', 'url' =>$portfolio->github];
    if (!empty($portfolio->linkedin)) $socials[] = ['label' => 'LinkedIn', 'url' =>$portfolio->linkedin];
    if (!empty($portfolio->twitter)) $socials[] = ['label' => 'Twitter / X', 'url' =>$portfolio->twitter];
    if (!empty($portfolio->facebook)) $socials[] = ['label' => 'Facebook', 'url' =>$portfolio->facebook];

    $shareUrl = !empty($portfolio->slug) ? url('/p/' . $portfolio->slug) : '';$hasId = !empty($portfolio->id);$editUrl = $hasId ? route('portfolios.edit', $portfolio->id) : '#';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7fb">
    <title>{{ $name }} | Portfolio</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="stylesheet" href="/css/templates/modern.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Additional styling to make the Dashboard button prominently visible */
        .dashboard-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #111827 !important;
            color: #ffffff !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            margin-left: auto;
        }
        .dashboard-nav-btn:hover {
            background: #374151 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <!-- Success Notification Pop-Up Modal -->
    @if(session('success') || request()->has('generated'))
        <div id="successModal" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px;">
            <div style="background: #ffffff; border: 2px solid #242424; border-radius: 16px; padding: 30px; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                
                <div style="font-size: 42px; margin-bottom: 10px;">🎉</div>
                
                <h2 style="font-size: 24px; font-weight: 900; margin: 0 0 10px; color: #111;">Portfolio Generated!</h2>
                
                <p style="font-size: 14px; color: #555; margin: 0 0 20px; line-height: 1.5;">
                    You have successfully chosen and generated your portfolio template! You can now copy the link below and share it with everyone.
                </p>

                @if(!empty($shareUrl))
                    <div style="display: flex; gap: 8px; margin-bottom: 15px;">
                        <input id="modalShareLink" type="text" value="{{ $shareUrl }}" readonly style="flex: 1; padding: 10px 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 13px; background: #f9fafb; font-weight: bold; color: #333;">
                        <button type="button" class="button" onclick="copyModalLink(this)" style="padding: 10px 16px; background: var(--accent, #4f46e5); color: white; border: none; border-radius: 8px; cursor: pointer;">Copy Link</button>
                    </div>
                @endif

                <button type="button" onclick="closeSuccessModal()" class="button" style="width: 100%; background: #111; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 5px;">
                    Got it, view portfolio!
                </button>
            </div>
        </div>

        <style>
            @keyframes popIn {
                0% { opacity: 0; transform: scale(0.8); }
                100% { opacity: 1; transform: scale(1); }
            }
        </style>
    @endif

    <!-- Top Navigation Bar with Embedded Dashboard Button -->
    <nav class="site-nav" aria-label="Main navigation">
        <a class="brand" href="#about" aria-label="Back to introduction">
            <span class="brand-mark" aria-hidden="true">PG</span>
            <span>{{ $name }}</span>
        </a>

        <div class="nav-links">
            <a href="#about" class="active">About</a>
            @if($groupedSections->has('projects') || !empty($portfolio->projects))
                <a href="#projects">Projects</a>
            @endif
            @if($groupedSections->has('education') || !empty($portfolio->experience))
                <a href="#background">Background</a>
            @endif
            @if($groupedSections->has('skills') || !empty($portfolio->skills))
                <a href="#skills">Skills</a>
            @endif
            @if(count($socials) > 0)
                <a href="#social">Social</a>
            @endif
        </div>

        <!-- Prominently Visible Dashboard Action Button -->
        @auth
            @if(isset($fromTemplate) &&$fromTemplate)
                <a href="{{ route('portfolios.chooseTemplate') }}" class="dashboard-nav-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to Templates
                </a>
            @else
                <a href="{{ route('home') }}" class="dashboard-nav-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Dashboard
                </a>
            @endif
        @endauth
    </nav>

    <main>
        <!-- INTRODUCTION -->
        <section id="about" class="hero container">
            <div class="hero-copy">
                <p class="eyebrow">Personal portfolio</p>
                <h1>Hello, I'm <span class="accent-text">{{ $name }}.</span></h1>
                <p class="hero-lead">{{ $headline }}</p>
                <p class="hero-about">{{ $about }}</p>

                <div class="contact-list">
                    @if (!empty($email))
                        <span class="contact-item">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm9 7L4 7v10h16V7l-8 5Zm0-2 7-4H5l7 4Z"/></svg>
                            {{ $email }}
                        </span>
                    @endif

                    @if (!empty($phone))
                        <span class="contact-item">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11 11 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11 11 0 0 0 .6 3.6 1 1 0 0 1-.25 1l-1.25 1.2Z"/></svg>
                            {{ $phone }}
                        </span>
                    @endif

                    @if (!empty($location))
                        <span class="contact-item">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/></svg>
                            {{ $location }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="portrait-wrap" aria-label="Profile photo">
                <div class="portrait-backdrop" aria-hidden="true"></div>
                <div class="portrait-frame">
                    @if (!empty($photo))
                        <img src="{{ $photo }}" alt="Portrait of {{ $name }}">
                    @else
                        {{ strtoupper(substr($name, 0, 1)) }}
                    @endif
                </div>
                <div class="portrait-label">A little about me&nbsp; ↘</div>
            </div>
        </section>

        <!-- PROJECTS -->
        @if($groupedSections->has('projects') || !empty($portfolio->projects))
            <section id="projects" class="section container">
                <div class="section-heading">
                    <div>
                        <span class="section-kicker">Selected work</span>
                        <h2>Projects I've built.</h2>
                    </div>
                    <p>A few projects that highlight my skills, ideas, and the problems I enjoy solving.</p>
                </div>

                <div class="project-grid">
                    @php $projectIndex = 1; @endphp
                    @if($groupedSections->has('projects'))
                        @foreach($groupedSections['projects'] as $item)
                            @if(!empty($item->content['title']))
                                <article class="project-card">
                                    <div class="project-body">
                                        <span class="project-number">PROJECT {{ str_pad((string)$projectIndex, 2, '0', STR_PAD_LEFT) }}</span>
                                        <h3>{{ $item->content['title'] }}</h3>
                                        <p>{{ $item->content['description'] ?? 'A project featured in my portfolio.' }}</p>
                                    </div>
                                    @if(!empty($item->content['link']))
                                        <div class="project-footer">
                                            <a href="{{ $item->content['link'] }}" target="_blank" rel="noopener noreferrer" class="button secondary" style="background:var(--accent-soft); color:var(--accent-dark); border:none; padding:8px 14px; font-size:0.8rem;">
                                                View Project &rarr;
                                            </a>
                                        </div>
                                    @endif
                                </article>
                                @php $projectIndex++; @endphp
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
        @endif

        <!-- EDUCATION AND EXPERIENCE -->
        @if($groupedSections->has('education') || !empty($portfolio->experience))
            <div id="background" class="background-section">
                <section class="container">
                    <div class="section-heading">
                        <div>
                            <span class="section-kicker">The journey</span>
                            <h2>Background & experience.</h2>
                        </div>
                        <p>The education and experiences that have helped me grow.</p>
                    </div>

                    <div class="background-grid">
                        <article class="background-card">
                            <h3><span aria-hidden="true">01</span> Education</h3>

                            @if($groupedSections->has('education'))
                                @foreach($groupedSections['education'] as $item)
                                    @if(!empty($item->content['school']))
                                        <div class="timeline-entry">
                                            <div class="entry-topline">
                                                <strong>{{ $item->content['degree'] ?? 'Degree' }}</strong>
                                                <span class="entry-period">{{ $item->content['year'] ?? '' }}</span>
                                            </div>
                                            <p class="entry-detail">{{ $item->content['school'] }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p class="entry-detail">Add your education details.</p>
                            @endif
                        </article>

                        <article class="background-card">
                            <h3><span aria-hidden="true">02</span> Experience</h3>

                            @if(!empty($portfolio->experience))
                                <div class="timeline-entry">
                                    <p class="entry-detail" style="white-space: pre-line;">{{ $portfolio->experience }}</p>
                                </div>
                            @else
                                <p class="entry-detail">Add your work experience here.</p>
                            @endif
                        </article>
                    </div>
                </section>
            </div>
        @endif

        <!-- SKILLS -->
        @php
            $skillsArray = [];
            if ($groupedSections->has('skills')) {
                foreach($groupedSections['skills'] as $item) {
                    $sList = is_array($item->content['skills'] ?? null) 
                        ? $item->content['skills'] 
                        : array_filter(array_map('trim', explode(',', $item->content['skills'] ?? '')));$skillsArray = array_merge($skillsArray,$sList);
                }
            } elseif (!empty($portfolio->skills)) {
                $skillsArray = array_filter(array_map('trim', explode(',',$portfolio->skills)));
            }
        @endphp

        @if(count($skillsArray) > 0)
            <section id="skills" class="section skills-section container">
                <div class="section-heading">
                    <span class="section-kicker">What I work with</span>
                    <h2>Skills & tools.</h2>
                    <p>The tools, technologies, and abilities I bring to a project.</p>
                </div>

                <div class="skill-list">
                    @foreach ($skillsArray as $s)
                        <span class="skill-tag">{{ $s }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- SOCIAL LINKS AND SHARE -->
        <section id="social" class="social-section container">
            @if(count($socials) > 0)
                <div class="section-heading">
                    <div>
                        <span class="section-kicker">Around the web</span>
                        <h2>Let's connect.</h2>
                    </div>
                    <p>Find me online or share this portfolio with someone.</p>
                </div>

                <ul class="social-list">
                    @foreach ($socials as $l)
                        <li>
                            <a href="{{ $l['url'] }}" target="_blank" rel="noopener noreferrer">
                                {{ $l['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @auth
                <div class="share-card">
                    <div class="share-copy">
                        <h3>Pass it along.</h3>
                        <p>Share your portfolio with classmates, recruiters, or collaborators.</p>
                    </div>

                    <div class="share-actions">
                        @if($hasId)
                            <input class="share-input" type="text" id="shareLink" value="{{ $shareUrl }}" readonly aria-label="Portfolio share link">
                            <button class="button" type="button" id="copyLinkButton" onclick="copyLink(this)">Copy link</button>
                            <a class="button secondary" href="{{ $editUrl }}">Edit portfolio</a>

                            <form
                                class="delete-form"
                                action="{{ route('portfolios.destroy', $portfolio->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this portfolio? This action cannot be undone.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="button danger" type="submit">Delete portfolio</button>
                            </form>
                        @else
                            <p style="color: #bdf5dc; font-size: 0.9rem;">This is a live preview. Click "Choose" on the template screen to generate your portfolio!</p>
                        @endif
                    </div>
                </div>
            @endauth
        </section>
    </main>

    <footer class="site-footer">
        &copy; {{ date('Y') }} {{ $name }}. Built with care.
    </footer>

    <script>
        const navLinks = [...document.querySelectorAll('.nav-links a')];
        const observedSections = navLinks
            .map((link) => document.querySelector(link.getAttribute('href')))
            .filter(Boolean);

        if ('IntersectionObserver' in window) {
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;

                    navLinks.forEach((link) => {
                        const isActive = link.getAttribute('href') === `#${entry.target.id}`;
                        link.classList.toggle('active', isActive);
                    });
                });
            }, {
                rootMargin: '-32% 0px -56% 0px',
                threshold: 0
            });

            observedSections.forEach((section) => sectionObserver.observe(section));
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        async function copyModalLink(button) {
            const input = document.getElementById('modalShareLink');
            if (!input) return;

            const originalText = button.textContent;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(input.value);
                } else {
                    input.focus();
                    input.select();
                    document.execCommand('copy');
                }
                button.textContent = 'Copied!';
            } catch (err) {
                input.focus();
                input.select();
                button.textContent = 'Copied!';
            }

            setTimeout(() => {
                button.textContent = originalText;
            }, 1800);
        }

        async function copyLink(button) {
            const input = document.getElementById('shareLink');
            if (!input) return;

            const originalText = button.textContent;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(input.value);
                } else {
                    input.focus();
                    input.select();
                    const copied = document.execCommand('copy');
                    if (!copied) throw new Error('Copy command failed');
                }

                button.textContent = 'Copied!';
            } catch (error) {
                input.focus();
                input.select();
                button.textContent = 'Select and copy';
            }

            window.setTimeout(() => {
                button.textContent = originalText;
            }, 1800);
        }
    </script>
</body>
</html>