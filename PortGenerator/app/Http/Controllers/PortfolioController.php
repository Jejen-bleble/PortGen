<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioSection;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        // Fetch portfolios belonging to the currently logged-in user[cite: 10]
        $portfolios = Portfolio::where('user_id', auth()->id())->get();

        return view('portfolios.home', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'headline'       => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'bio'            => 'nullable|string',
            'experience'     => 'nullable|string',
            'skills'         => 'nullable|string',

            // Education array validation[cite: 10]
            'education'            => 'nullable|array',
            'education.*.school'   => 'nullable|string|max:255',
            'education.*.degree'   => 'nullable|string|max:255',
            'education.*.year'     => 'nullable|string|max:50',
            
            // Projects array validation[cite: 10]
            'projects'             => 'nullable|array',
            'projects.*.title'     => 'nullable|string|max:255',
            'projects.*.link'      => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',

            'github'         => 'nullable|string|max:255',
            'linkedin'       => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'facebook'       => 'nullable|string|max:255',
            'profile_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        
        // 1. Handle image upload first so the path is included in $validated[cite: 10]
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('portfolios', 'public');
        }

        // 2. Save data to session for the template selection step[cite: 10]
        session(['portfolio_data' => $validated]);

        // 3. Redirect to the choose template step[cite: 10]
        return redirect()->route('portfolios.chooseTemplate');
    }

    public function chooseTemplate()
    {
        if (!session()->has('portfolio_data')) {
            return redirect()->route('portfolios.create');
        }

        $templates = Template::all();
        return view('portfolios.choose-template', compact('templates'));
    }

    /**
     * Preview selected template using active session data before generating.[cite: 10]
     */
    public function previewTemplate($templateId)
    {
        $data = session('portfolio_data');
        if (!$data) {
            return redirect()->route('portfolios.create')->with('error', 'Please fill out your details first.');
        }

        $template = Template::findOrFail($templateId);

        // Build a mock Portfolio object for previewing session data[cite: 10]
        $portfolio = new Portfolio($data);
        $portfolio->slug = 'preview';

        // Map session arrays into mock relationship objects for the template views[cite: 10]
        $educations = collect($data['education'] ?? [])->map(fn($edu) => (object)[
            'section_type' => 'education',
            'content' => $edu
        ]);

        $skillsArray = array_values(array_filter(array_map('trim', explode(',', $data['skills'] ?? ''))));
        $skillsSection = !empty($skillsArray) ? collect([(object)[
            'section_type' => 'skills',
            'content' => ['skills' => $skillsArray]
        ]]) : collect();

        $projects = collect($data['projects'] ?? [])->map(fn($proj) => (object)[
            'section_type' => 'projects',
            'content' => $proj
        ]);

        $portfolio->setRelation('sections', $educations->concat($skillsSection)->concat($projects));
        $portfolio->setRelation('template', $template);

        $viewName = 'portfolios.templates.' . ($template->slug ?? 'modern');
        if (!view()->exists($viewName)) {
            $viewName = 'portfolios.templates.modern';
        }

        // Check if coming from choose-template route[cite: 10]
        $fromTemplate = request()->has('from') && request()->get('from') == 'template';

        return view($viewName, compact('portfolio', 'fromTemplate'));
    }

    public function generateFinal(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
        ]);

        $data = session('portfolio_data');
        if (!$data) {
            return redirect()->route('portfolios.create');
        }

        // Explicitly set user_id, slug, and template_id[cite: 10]
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['full_name']) . '-' . rand(1000, 9999);
        $data['template_id'] = $request->template_id;

        $educations = $data['education'] ?? [];
        $skillsString = $data['skills'] ?? '';
        $projects = $data['projects'] ?? [];

        unset($data['education'], $data['skills'], $data['projects']);

        // 1. Create Main Portfolio Record[cite: 10]
        $portfolio = Portfolio::create($data);
        $order = 1;

        // 2. Save Education Entries[cite: 10]
        foreach ($educations as $edu) {
            if (!empty($edu['school'])) {
                PortfolioSection::create([
                    'portfolio_id' => $portfolio->id,
                    'section_type' => 'education',
                    'content' => $edu,
                    'order' => $order++,
                ]);
            }
        }

        // 3. Save Skills Section[cite: 10]
        $skillsArray = array_values(array_filter(array_map('trim', explode(',', $skillsString))));
        if (!empty($skillsArray)) {
            PortfolioSection::create([
                'portfolio_id' => $portfolio->id,
                'section_type' => 'skills',
                'content' => ['skills' => $skillsArray],
                'order' => $order++,
            ]);
        }

        // 4. Save Project Entries[cite: 10]
        foreach ($projects as $proj) {
            if (!empty($proj['title'])) {
                PortfolioSection::create([
                    'portfolio_id' => $portfolio->id,
                    'section_type' => 'projects',
                    'content' => $proj,
                    'order' => $order++,
                ]);
            }
        }

        session()->forget('portfolio_data');

        return redirect(url('/p/' . $portfolio->slug))->with('success', 'Portfolio generated successfully!');
    }

    public function show($slug)
    {
        $portfolio = Portfolio::with(['template', 'sections'])->where('slug', $slug)->firstOrFail();

        $viewName = 'portfolios.templates.' . ($portfolio->template->slug ?? 'modern');
        if (!view()->exists($viewName)) {
            $viewName = 'portfolios.templates.modern';
        }

        return view($viewName, compact('portfolio'));
    }

    /**
     * Show the form for editing an existing portfolio.[cite: 10]
     */
    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id()) {
            abort(403);
        }

        $portfolio->load('sections');

        return view('portfolios.edit', compact('portfolio'));
    }

    /**
     * Update an existing portfolio in the database.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'headline'       => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:255',
            'bio'            => 'nullable|string',
            'experience'     => 'nullable|string',
            'skills'         => 'nullable|string',

            'education'            => 'nullable|array',
            'education.*.school'   => 'nullable|string|max:255',
            'education.*.degree'   => 'nullable|string|max:255',
            'education.*.year'     => 'nullable|string|max:50',
            
            'projects'             => 'nullable|array',
            'projects.*.title'     => 'nullable|string|max:255',
            'projects.*.link'      => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',

            'github'         => 'nullable|string|max:255',
            'linkedin'       => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'facebook'       => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($portfolio->profile_image) {
                Storage::disk('public')->delete($portfolio->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('portfolios', 'public');
        }

        $educations = $validated['education'] ?? [];
        $skillsString = $validated['skills'] ?? '';
        $projects = $validated['projects'] ?? [];

        // Remove arrays from main portfolio update payload
        unset($validated['education'], $validated['skills'], $validated['projects']);

        // 1. Update main portfolio details
        $portfolio->update($validated);

        // 2. Refresh sections in the database so edits persist and show up on reload
        $portfolio->sections()->delete();
        $order = 1;

        // Save Education Sections
        foreach ($educations as $edu) {
            if (!empty($edu['school'])) {
                PortfolioSection::create([
                    'portfolio_id' => $portfolio->id,
                    'section_type' => 'education',
                    'content' => $edu,
                    'order' => $order++,
                ]);
            }
        }

        // Save Skills Section
        $skillsArray = array_values(array_filter(array_map('trim', explode(',', $skillsString))));
        if (!empty($skillsArray)) {
            PortfolioSection::create([
                'portfolio_id' => $portfolio->id,
                'section_type' => 'skills',
                'content' => ['skills' => $skillsArray],
                'order' => $order++,
            ]);
        }

        // Save Project Sections
        foreach ($projects as $proj) {
            if (!empty($proj['title'])) {
                PortfolioSection::create([
                    'portfolio_id' => $portfolio->id,
                    'section_type' => 'projects',
                    'content' => $proj,
                    'order' => $order++,
                ]);
            }
        }
        
        return redirect()->route('home')->with('success', 'Portfolio updated successfully!');
    }

    /**
     * Remove the specified portfolio from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== auth()->id()) {
            abort(403);
        }

        if ($portfolio->profile_image) {
            Storage::disk('public')->delete($portfolio->profile_image);
        }

        $portfolio->sections()->delete();
        $portfolio->delete();

        return redirect()->route('home')->with('success', 'Portfolio deleted successfully!');
    }
}