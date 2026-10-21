@php
    $name = $portfolio->full_name ?: 'Your Name';
    $headline = $portfolio->headline ?: 'Developer / Professional';
    $about = $portfolio->bio ?: 'A snapshot of my work, experience, and the things I love creating.';
    $email = $portfolio->email ?? '';
    $phone = $portfolio->contact_number ?? '';
    $location = $portfolio->address ?? '';
    $photo = $portfolio->profile_image
        ? asset('storage/' . $portfolio->profile_image)
        : null;

    $groupedSections = $portfolio->sections ? $portfolio->sections->groupBy('section_type') : collect();

    // Social links array
    $socials = [];
    if (!empty($portfolio->github)) $socials[] = ['label' => 'GitHub', 'url' => $portfolio->github];
    if (!empty($portfolio->linkedin)) $socials[] = ['label' => 'LinkedIn', 'url' => $portfolio->linkedin];
    if (!empty($portfolio->twitter)) $socials[] = ['label' => 'Twitter / X', 'url' => $portfolio->twitter];
    if (!empty($portfolio->facebook)) $socials[] = ['label' => 'Facebook', 'url' => $portfolio->facebook];

    $shareUrl = !empty($portfolio->slug) ? url('/p/' . $portfolio->slug) : '';
    $hasId = !empty($portfolio->id);
    $editUrl = $hasId ? route('portfolios.edit', $portfolio->id) : '#';
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
</head>
<body>
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

    <!-- Floating Back / Dashboard Button with Dynamic Preview Support -->
    @auth
        <div style="position: fixed; bottom: 25px; right: 25px; z-index: 100;">
            @if(isset($fromTemplate) && $fromTemplate)
                <a href="{{ route('portfolios.chooseTemplate') }}" class="button" style="box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                    &larr; Back to Templates
                </a>
            @else
                <a href="{{ route('home') }}" class="button" style="box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                    &larr; Dashboard
                </a>
            @endif
        </div>
    @endauth

    <script>
        // Highlight the navigation item that matches the section currently in view.
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

        // Copy the public portfolio URL, with a fallback for browsers without Clipboard API access.
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