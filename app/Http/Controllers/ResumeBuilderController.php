<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ResumeBuilderController extends Controller
{
    public function show()
    {
        if (!Session::get('user_id')) {
            return redirect()->route('login');
        }

        $user_id = Session::get('user_id');
        $resume = DB::table('resumes')->where('user_id', $user_id)->first();

        return view('builder.index', ['resume' => $resume]);
    }

    public function store(Request $request)
    {
        if (!Session::get('user_id')) {
            return redirect()->route('login');
        }

        $user_id = Session::get('user_id');

        // Get existing resume or create new
        $existing = DB::table('resumes')->where('user_id', $user_id)->first();
        
        // Generate slug if new
        $slug = $existing ? $existing->slug : Str::slug($request->input('name', 'resume') . '-' . $user_id . '-' . time());

        // Process arrays
        $tech_stack = array_filter(array_map('trim', explode(',', $request->input('tech_stack', ''))));
        $tech_stack = array_values($tech_stack);

        // Process experience
        $experience = [];
        if ($request->has('experience') && is_array($request->input('experience'))) {
            foreach ($request->input('experience') as $exp) {
                if (!empty($exp['year']) || !empty($exp['title']) || !empty($exp['org'])) {
                    $experience[] = [
                        'year' => $exp['year'] ?? '',
                        'title' => $exp['title'] ?? '',
                        'org' => $exp['org'] ?? '',
                        'current' => isset($exp['current']) && $exp['current'] == '1',
                    ];
                }
            }
        }

        // Process education
        $education = [];
        if ($request->has('education') && is_array($request->input('education'))) {
            foreach ($request->input('education') as $edu) {
                if (!empty($edu['year']) || !empty($edu['title']) || !empty($edu['org'])) {
                    $education[] = [
                        'year' => $edu['year'] ?? '',
                        'title' => $edu['title'] ?? '',
                        'org' => $edu['org'] ?? '',
                        'current' => isset($edu['current']) && $edu['current'] == '1',
                    ];
                }
            }
        }

        // Process projects
        $projects = [];
        if ($request->has('projects') && is_array($request->input('projects'))) {
            foreach ($request->input('projects') as $project) {
                if (!empty($project['title']) || !empty($project['description']) || !empty($project['link'])) {
                    $projects[] = [
                        'title' => $project['title'] ?? '',
                        'description' => $project['description'] ?? '',
                        'link' => $project['link'] ?? '',
                    ];
                }
            }
        }

        $data = [
            'user_id' => $user_id,
            'slug' => $slug,
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'location' => $request->input('location'),
            'about' => $request->input('about'),
            'contact_number' => $request->input('contact_number'),
            'contact_email' => $request->input('contact_email'),
            'tech_stack' => json_encode($tech_stack),
            'experience' => json_encode($experience),
            'education' => json_encode($education),
            'projects' => json_encode($projects),
            'github_url' => $request->input('github_url'),
            'resume_pdf_url' => $request->input('resume_pdf_url'),
            'updated_at' => now(),
        ];

        if ($existing) {
            DB::table('resumes')->where('id', $existing->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('resumes')->insert($data);
        }

        return redirect()->route('resume.public', ['slug' => $slug])->with('success', 'Resume saved!');
    }
}

