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

    // Skills array calculation
    $skillsArray = [];
    if ($groupedSections->has('skills')) {
        foreach($groupedSections['skills'] as $item) {
            $sList = is_array($item->content['skills'] ?? null) 
                ? $item->content['skills'] 
                : array_filter(array_map('trim', explode(',', $item->content['skills'] ?? '')));
            $skillsArray = array_merge($skillsArray, $sList);
        }
    } elseif (!empty($portfolio->skills)) {
        $skillsArray = array_filter(array_map('trim', explode(',', $portfolio->skills)));
    }

    $shareUrl = !empty($portfolio->slug) ? url('/p/' . $portfolio->slug) : '';
    $hasId = !empty($portfolio->id);
    $editUrl = $hasId ? route('portfolios.edit', $portfolio->id) : '#';
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name }} — Portfolio</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .timeline-line::before {
            content: '';
            position: absolute;
            top: 14px;
            bottom: 0;
            left: 11px;
            width: 2px;
            background-color: #cbd5e1;
            z-index: 0;
        }
    </style>
</head>
<body class="bg-gray-100 text-slate-800 font-sans antialiased min-h-screen py-8">

    <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
        
        <!-- Header / Banner Section -->
        <header class="bg-[#212b59] text-white py-10 px-8 relative">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Spacer for avatar overflow on desktop -->
                <div class="hidden md:block md:col-span-4"></div>
                
                <div class="md:col-span-8 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wider text-white">
                        {{ $name }}
                    </h1>
                    <p class="text-slate-300 font-medium text-sm md:text-base uppercase tracking-widest mt-1">
                        {{ $headline }}
                    </p>
                </div>
            </div>
        </header>

        <!-- Main Content Area with 2-Column Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 relative">
            
            <!-- Left Sidebar -->
            <aside class="md:col-span-4 bg-[#eef2f6] px-6 pb-12 pt-6 md:pt-0 relative border-r border-slate-200">
                
                <!-- Circular Profile Photo -->
                <div class="flex justify-center md:justify-start md:-mt-24 mb-8 relative z-10">
                    @if(!empty($photo))
                        <img src="{{ $photo }}" alt="{{ $name }}" class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-md">
                    @else
                        <div class="w-40 h-40 rounded-full bg-[#dbe5f1] border-4 border-white shadow-md flex items-center justify-center text-4xl font-bold text-[#212b59]">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    
                    <!-- Contact Section -->
                    @if($email || $phone || $location)
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-widest text-[#212b59] pb-2 border-b-2 border-slate-300 mb-4">
                                Contact
                            </h2>
                            <ul class="space-y-3 text-xs text-slate-600">
                                @if($phone)
                                    <li class="flex items-center gap-3">
                                        <i class="fa-solid fa-phone text-[#212b59] w-4"></i>
                                        <span>{{ $phone }}</span>
                                    </li>
                                @endif
                                @if($email)
                                    <li class="flex items-center gap-3 break-all">
                                        <i class="fa-solid fa-envelope text-[#212b59] w-4"></i>
                                        <a href="mailto:{{ $email }}" class="hover:underline">{{ $email }}</a>
                                    </li>
                                @endif
                                @if($location)
                                    <li class="flex items-center gap-3">
                                        <i class="fa-solid fa-location-dot text-[#212b59] w-4"></i>
                                        <span>{{ $location }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- Skills Section -->
                    @if(count($skillsArray) > 0)
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-widest text-[#212b59] pb-2 border-b-2 border-slate-300 mb-4">
                                Skills
                            </h2>
                            <ul class="list-disc list-inside space-y-1.5 text-xs text-slate-700">
                                @foreach($skillsArray as $s)
                                    <li>{{ $s }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Projects Section -->
                    @if($groupedSections->has('projects') || !empty($portfolio->projects))
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-widest text-[#212b59] pb-2 border-b-2 border-slate-300 mb-4">
                                Projects
                            </h2>
                            <div class="space-y-4">
                                @if($groupedSections->has('projects'))
                                    @foreach($groupedSections['projects'] as $item)
                                        @if(!empty($item->content['title']))
                                            <div class="text-xs">
                                                <div class="font-bold text-slate-800 flex justify-between items-baseline">
                                                    <span>{{ $item->content['title'] }}</span>
                                                    @if(!empty($item->content['link']))
                                                        <a href="{{ $item->content['link'] }}" target="_blank" class="text-blue-600 hover:underline text-[10px]">View →</a>
                                                    @endif
                                                </div>
                                                @if(!empty($item->content['description']))
                                                    <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">{{ $item->content['description'] }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Social Links Section -->
                    @if(count($socials) > 0)
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-widest text-[#212b59] pb-2 border-b-2 border-slate-300 mb-4">
                                Social Links
                            </h2>
                            <ul class="space-y-2 text-xs">
                                @foreach($socials as $l)
                                    <li>
                                        <a href="{{ $l['url'] }}" target="_blank" class="text-slate-700 hover:text-[#212b59] hover:underline flex items-center gap-2">
                                            <i class="fa-solid fa-link text-[10px] text-[#212b59]"></i>
                                            {{ $l['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </aside>

            <!-- Right Main Content Area (Timeline Style) -->
            <main class="md:col-span-8 p-8 md:p-10 space-y-10 relative timeline-line">

                <!-- About Me -->
                <div class="relative z-10 pl-8">
                    <div class="absolute -left-[1px] top-0.5 w-6 h-6 rounded-full bg-[#212b59] flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-white"></div>
                    </div>
                    <h2 class="text-base font-bold uppercase tracking-wider text-[#212b59] pb-1 border-b border-slate-300 mb-3">
                        About Me
                    </h2>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                        {{ $about }}
                    </p>
                </div>

                <!-- Work Experience -->
                @if(!empty($portfolio->experience))
                    <div class="relative z-10 pl-8">
                        <div class="absolute -left-[1px] top-0.5 w-6 h-6 rounded-full bg-[#212b59] flex items-center justify-center">
                            <div class="w-2 h-2 rounded-full bg-white"></div>
                        </div>
                        <h2 class="text-base font-bold uppercase tracking-wider text-[#212b59] pb-1 border-b border-slate-300 mb-4">
                            Work Experience
                        </h2>
                        <div class="text-xs md:text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                            {{ $portfolio->experience }}
                        </div>
                    </div>
                @endif

                <!-- Educational Background -->
                @if($groupedSections->has('education'))
                    <div class="relative z-10 pl-8">
                        <div class="absolute -left-[1px] top-0.5 w-6 h-6 rounded-full bg-[#212b59] flex items-center justify-center">
                            <div class="w-2 h-2 rounded-full bg-white"></div>
                        </div>
                        <h2 class="text-base font-bold uppercase tracking-wider text-[#212b59] pb-1 border-b border-slate-300 mb-4">
                            Educational Background
                        </h2>
                        <div class="space-y-4">
                            @foreach($groupedSections['education'] as $item)
                                @if(!empty($item->content['school']))
                                    <div class="flex justify-between items-start text-xs md:text-sm">
                                        <div>
                                            <h3 class="font-bold text-slate-800">{{ $item->content['degree'] ?? 'Degree / Major' }}</h3>
                                            <p class="text-slate-600 text-xs mt-0.5">{{ $item->content['school'] }}</p>
                                        </div>
                                        @if(!empty($item->content['year']))
                                            <span class="text-xs font-semibold text-slate-500 whitespace-nowrap ml-4">
                                                {{ $item->content['year'] }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

            </main>
        </div>

        <!-- Shareable Link Box / Action Banner -->
        @auth
            <div class="bg-[#192142] text-white p-6 border-t border-slate-800">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-bold text-white">Share Your Portfolio</h3>
                        <p class="text-xs text-slate-400">Copy your portfolio link to share it with others.</p>
                    </div>
                    @if($hasId)
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <input type="text" id="portfolio-url" readonly value="{{ $shareUrl }}" 
                                   class="bg-white text-slate-800 text-xs px-3 py-2 rounded w-full md:w-72 outline-none select-all">
                            <button onclick="copyPortfolioUrl()" id="copy-btn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded transition-all shrink-0">
                                Copy Link
                            </button>
                            <a href="{{ $editUrl }}" class="px-4 py-2 border border-slate-600 hover:bg-slate-800 text-white text-xs font-semibold rounded transition-all shrink-0">
                                Edit Portfolio
                            </a>
                        </div>
                    @else
                        <p class="text-xs text-slate-400">This is a live preview. Choose this template from the setup screen to generate your final portfolio.</p>
                    @endif
                </div>
            </div>
        @endauth

        <!-- Footer -->
        <footer class="bg-slate-100 py-4 text-center text-xs text-slate-500 border-t border-slate-200">
            © {{ date('Y') }} {{ $name }}. All rights reserved.
        </footer>

    </div>

    <!-- Floating Dashboard Button -->
    @auth
        <div style="position: fixed; bottom: 25px; right: 25px; z-index: 100;">
            @if(isset($fromTemplate) && $fromTemplate)
                <a href="{{ route('portfolios.chooseTemplate') }}" class="px-4 py-2.5 bg-slate-900 text-white text-xs font-semibold rounded-full shadow-2xl hover:bg-slate-800 transition-all inline-block">
                    &larr; Back to Templates
                </a>
            @else
                <a href="{{ route('home') }}" class="px-4 py-2.5 bg-slate-900 text-white text-xs font-semibold rounded-full shadow-2xl hover:bg-slate-800 transition-all inline-block">
                    &larr; Dashboard
                </a>
            @endif
        </div>
    @endauth

    <script>
        function copyPortfolioUrl() {
            const urlInput = document.getElementById('portfolio-url');
            if(!urlInput) return;
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(urlInput.value);
            const btn = document.getElementById('copy-btn');
            btn.innerText = 'Copied';
            setTimeout(() => {
                btn.innerText = 'Copy Link';
            }, 2000);
        }
    </script>

</body>
</html>