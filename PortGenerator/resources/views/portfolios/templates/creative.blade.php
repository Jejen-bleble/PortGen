<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/templates/creative.css">
    <title>{{ $portfolio->full_name }} | Creative Portfolio</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">

</head>
<body>

    @php
        $groupedSections =$portfolio->sections->groupBy('section_type');
    @endphp

    <!-- Sticky Navigation Bar -->
    <nav style="position: sticky; top: 0; z-index: 1000; background: rgba(248, 245, 239, 0.92); backdrop-filter: blur(8px); border-bottom: 1px solid rgba(36, 36, 36, 0.1);">
        <div class="container" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding-top: 15px; padding-bottom: 15px; margin: 0 auto;">
            <a class="brand" href="#home">
                <span>✳</span> {{ $portfolio->full_name }}
            </a>

            <div class="nav-links">
                <a href="#home">Home</a>
                @if (!empty($portfolio->bio))
                    <a href="#about">About</a>
                @endif
                @if ($groupedSections->has('projects') || !empty($portfolio->projects))
                    <a href="#projects">Projects</a>
                @endif
                @if ($groupedSections->has('skills') || empty($portfolio->skills))
                    <a href="#skills">Skills</a>
                @endif
                @if ($groupedSections->has('education') || !empty($portfolio->experience))
                    <a href="#background">My Journey</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">

        <!-- Hero Section -->
        <header class="hero" id="home">
            <div>
                <span class="tag">CREATIVE PORTFOLIO ✦</span>

                <h1>Hey, I'm<br><span>{{ $portfolio->full_name }}</span></h1>

                <p class="hero-description">
                    {{ $portfolio->bio ?? $portfolio->headline ?? 'Welcome to my creative portfolio. Explore my work, skills, and experience.' }}
                </p>

                <div class="contact-row">
                    @if (!empty($portfolio->email))
                        <a class="button" href="mailto:{{ $portfolio->email }}">
                            Let's Connect ↗
                        </a>
                    @endif

                    @if ($groupedSections->has('projects') || !empty($portfolio->projects))
                        <a class="button button-outline" href="#projects">
                            Explore My Work
                        </a>
                    @endif
                </div>

                @if (!empty($portfolio->contact_number))
                    <p style="margin-top:18px;font-size:13px;color:#666;font-weight: bold;">
                        Contact: {{ $portfolio->contact_number }}
                    </p>
                @endif

                @if (!empty($portfolio->address))
                    <p style="font-size:13px;color:#666;">
                        📍 {{ $portfolio->address }}
                    </p>
                @endif
            </div>

            <!-- Portrait / Avatar Area -->
            <div class="portrait-area">
                @if (!empty($portfolio->profile_image))
                    <img class="profile-picture" src="{{ asset('storage/' . $portfolio->profile_image) }}" alt="{{ $portfolio->full_name }}">
                @else
                    <div class="photo-placeholder">
                        {{ strtoupper(substr($portfolio->full_name ?? 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="sticker">LET'S<br>CREATE!</div>
            </div>
        </header>

        <!-- About Me Section -->
        @if (!empty($portfolio->bio))
            <section class="section" id="about">
                <div class="section-header">
                    <h2>A Little About Me</h2>
                    <p>THE PERSON BEHIND THE WORK</p>
                </div>

                <div class="about-card">
                    <h2>Curious mind. Creative ideas.</h2>
                    <p>{{ $portfolio->bio }}</p>
                </div>
            </section>
        @endif

        <!-- Projects Section -->
        @if ($groupedSections->has('projects') || !empty($portfolio->projects))
            <section class="section" id="projects">
                <div class="section-header">
                    <h2>Things I've Created ✳</h2>
                    <p>A SELECTION OF MY PROJECTS</p>
                </div>

                <div class="project-grid">
                    @php $projectNumber = 1; @endphp

                    @if($groupedSections->has('projects'))
                        @foreach($groupedSections['projects'] as $section)
                            @if(!empty($section->content['title']))
                                <article class="project-card">
                                    <span class="project-number">
                                        PROJECT {{ str_pad($projectNumber, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <h3>{{ $section->content['title'] }}</h3>
                                    @if(!empty($section->content['description']))
                                        <p>{{ $section->content['description'] }}</p>
                                    @else
                                        <p>A project featured in my portfolio.</p>
                                    @endif
                                    @if(!empty($section->content['link']))
                                        <a href="{{ $section->content['link'] }}" target="_blank" rel="noopener noreferrer" class="project-link">
                                            View Project ↗
                                        </a>
                                    @endif
                                </article>
                                @php $projectNumber++; @endphp
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
        @endif

        <!-- Journey Section (Education & Work Experience) -->
        @if ($groupedSections->has('education') || !empty($portfolio->experience))
            <section class="section" id="background">
                <div class="section-header">
                    <h2>My Journey</h2>
                    <p>LEARNING, GROWING, CREATING</p>
                </div>

                <div class="details-grid">
                    @if ($groupedSections->has('education'))
                        <article class="detail-card">
                            <h3>🎓 Education</h3>
                            <div style="display: flex; flex-direction: column; gap: 14px;">
                                @foreach($groupedSections['education'] as $section)
                                    @if(!empty($section->content['school']))
                                        <div>
                                            <p style="font-weight: bold; color: #242424; margin: 0;">{{ $section->content['school'] }}</p>
                                            @if(!empty($section->content['degree']))
                                                <p style="margin: 2px 0; font-size: 13px;">{{ $section->content['degree'] }}</p>
                                            @endif
                                            @if(!empty($section->content['year']))
                                                <p style="margin: 0; font-size: 12px; color: #777;">{{ $section->content['year'] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </article>
                    @endif

                    @if (!empty($portfolio->experience))
                        <article class="detail-card">
                            <h3>✦ Work Experience</h3>
                            <p>{{ $portfolio->experience }}</p>
                        </article>
                    @endif
                </div>
            </section>
        @endif

        <!-- Skills Section -->
        @if ($groupedSections->has('skills') || !empty($portfolio->skills))
            <section class="section" id="skills">
                <div class="section-header">
                    <h2>My Creative Toolkit</h2>
                    <p>SKILLS AND THINGS I KNOW</p>
                </div>

                <div class="skills">
                    @php
                        $skillsArray = [];
                        if ($groupedSections->has('skills')) {
                            foreach($groupedSections['skills'] as $section) {
                                $sList = is_array($section->content['skills'] ?? null) 
                                    ? $section->content['skills'] 
                                    : array_filter(array_map('trim', explode(',', $section->content['skills'] ?? '')));$skillsArray = array_merge($skillsArray,$sList);
                            }
                        } elseif (!empty($portfolio->skills)) {
                            $skillsArray = array_filter(array_map('trim', explode(',',$portfolio->skills)));
                        }
                    @endphp

                    @foreach ($skillsArray as $skill)
                        @if (!empty($skill))
                            <span class="skill">{{ $skill }}</span>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Social Media Links -->
        @php
            $socials = [];
            if (!empty($portfolio->github)) $socials[] = ['name' => 'GitHub', 'url' =>$portfolio->github];
            if (!empty($portfolio->linkedin)) $socials[] = ['name' => 'LinkedIn', 'url' =>$portfolio->linkedin];
            if (!empty($portfolio->twitter)) $socials[] = ['name' => 'Twitter / X', 'url' =>$portfolio->twitter];
            if (!empty($portfolio->facebook)) $socials[] = ['name' => 'Facebook', 'url' =>$portfolio->facebook];
        @endphp

        @if(count($socials) > 0)
            <section class="section">
                <div class="section-header">
                    <h2>Find Me Online ↗</h2>
                    <p>LET'S STAY CONNECTED</p>
                </div>

                <div class="social-list">
                    @foreach ($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
                            {{ $social['name'] }} ↗
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Shareable Link & Dashboard Actions -->
        @auth
            <section class="share-section">
                <h2>Like What You See? ✳</h2>
                
                @if(!empty($portfolio->id))
                    <p>Copy your public portfolio link to submit it or share it with anyone.</p>

                    <div class="share-row" style="margin-top: 15px;">
                        <input id="shareLink" type="text" value="{{ url('/p/' . $portfolio->slug) }}" readonly>
                        <button type="button" class="button" onclick="copyLink(this)">Copy Link</button>
                    </div>

                    <p id="copyMessage" style="display: none; color: #555; font-size: 13px; margin-top: 6px;">Link copied successfully!</p>

                    <div class="actions">
                        <a class="button edit-button" href="{{ route('portfolios.edit', $portfolio->id) }}">
                            Edit Portfolio
                        </a>

                        <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button class="button delete-button" type="submit">Delete Portfolio</button>
                        </form>
                    </div>
                @else
                    <p style="color: #d7f36b; font-size: 13px; margin-top: 8px;">
                        This is a live preview of your details. Click <strong>"Choose"</strong> on the template selection screen to generate your final portfolio!
                    </p>
                @endif
            </section>
        @endauth

        <!-- Footer -->
        <footer>
            Made with creativity ✳ | &copy; {{ date('Y') }} {{ $portfolio->full_name }}. Built with PortGen.
        </footer>

    </div>

   <!-- Floating Back / Dashboard Button with Dynamic Preview Support -->
    @auth
        <div style="position: fixed; bottom: 25px; right: 25px; z-index: 100;">
            @if(isset($fromTemplate) &&$fromTemplate)
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
            const message = document.getElementById('copyMessage');

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
                if (message) {
                    message.style.display = 'block';
                }
            } catch (error) {
                input.focus();
                input.select();
                button.textContent = 'Select and copy';
            }

            window.setTimeout(() => {
                button.textContent = originalText;
                if (message) {
                    message.style.display = 'none';
                }
            }, 1800);
        }
    </script>

</body>
</html>