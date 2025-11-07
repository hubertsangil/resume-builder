<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicResumeController extends Controller
{
    public function show($slug)
    {
        $resume = DB::table('resumes')->where('slug', $slug)->first();

        if (!$resume) {
            abort(404, 'Resume not found');
        }

        return view('resume.public', [
            'name' => $resume->name,
            'title' => $resume->title,
            'location' => $resume->location,
            'about' => $resume->about,
            'contact_number' => $resume->contact_number,
            'contact_email' => $resume->contact_email,
            'tech_stack' => json_decode($resume->tech_stack, true) ?: [],
            'experience' => json_decode($resume->experience, true) ?: [],
            'education' => json_decode($resume->education, true) ?: [],
            'projects' => json_decode($resume->projects, true) ?: [],
            'github_url' => $resume->github_url,
            'resume_pdf_url' => $resume->resume_pdf_url,
        ]);
    }
}

