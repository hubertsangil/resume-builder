<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ResumeController extends Controller
{
    public function show(Request $request)
    {
        if (!Session::get('user_id')) {
            return redirect()->route('login');
        }

        // Preserve variable names
        $name = "Hubert San Gil";
        $title = "3rd Year | BS Computer Science";
        $location = "Lucena City, Quezon, Philippines";
        $about = "I'm currently a third-year student taking up BS Computer Science in Batangas State University Alangilan.
I have a strong passion for technology and programming, and I'm always eager to learn new skills and improve my knowledge in the field. In addition to my academic pursuits,
In my free time I like to do graphic design and explore creative-related technologies.";
        $contact_number = "0947 7464 585";
        $contact_email = "sangilhubertross@gmail.com";

        $tech_stack = [
            "Java",
            "Python",
            "HTML",
            "CSS",
            "C++",
            "C#",
        ];

        $experience = [
            [
                "year" => "2025",
                "title" => "Committee Head on Technical Affairs",
                "org" => "CICS-SC Alangilan",
                "current" => true,
            ],
            [
                "year" => "2025",
                "title" => "Senior Media & Creatives Officer",
                "org" => "ADSS BatStateU Alangilan",
                "current" => true,
            ],
            [
                "year" => "2024",
                "title" => "Director for Marketing & Publications",
                "org" => "Junior Philippine Computer Society - BatStateU Alangilan",
                "current" => false,
            ],
        ];

        $education = [
            [
                "year" => "2023 - Present",
                "title" => "Bachelor of Science in Computer Science",
                "org" => "Batangas State University - Alangilan Campus",
                "current" => true,
            ],
            [
                "year" => "2017 - 2023",
                "title" => "Senior High School - STEM Strand",
                "org" => "Quezon National High School",
                "current" => false,
            ],
            [
                "year" => "2010 - 2017",
                "title" => "Primary School",
                "org" => "Lucena West 1 Elementary School",
                "current" => false,
            ],
        ];

        $projects = [
            [
                'title' => 'RememBert',
                'description' => 'A simple Java console-based task tracker',
                'link' => 'https://github.com/hubertsangil/RememBert',
            ],
        ];

        $user_id = Session::get('user_id');
        $resume_data = DB::table('resumes')->where('user_id', $user_id)->first();
        $profile_photo = $resume_data ? $resume_data->profile_photo : null;

        return view('pages.resume', compact(
            'name',
            'title',
            'location',
            'about',
            'contact_number',
            'contact_email',
            'tech_stack',
            'experience',
            'education',
            'projects',
            'profile_photo'
        ));
    }
}


