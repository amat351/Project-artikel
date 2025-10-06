<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data profil - bisa dipindah ke model atau config
        $profile = [
            'name' => 'Muhammad Eka Nur Fauzi',
            'title' => 'Full Stack Developer & Creative Technologist',
            'description' => 'Passionate developer dengan pengalaman dalam menciptakan solusi digital yang inovatif dan user-friendly. Selalu bersemangat dalam mengeksplorasi teknologi terbaru.',
            'about' => 'Seorang full stack developer dengan passion dalam teknologi web modern. Memiliki pengalaman dalam mengembangkan aplikasi web yang scalable dan maintainable menggunakan berbagai teknologi terkini. Saya selalu berusaha untuk menulis clean code dan mengikuti best practices dalam development.',
            'skills' => [
                'PHP & Laravel',
                'JavaScript & Vue.js', 
                'MySQL & PostgreSQL',
                'HTML5 & CSS3',
                'Git & GitHub',
                'RESTful API',
                'Bootstrap & Tailwind',
                'Docker',
                'Linux Server',
                'Node.js',
                'React.js',
                'MongoDB'
            ],
            'philosophy' => '"Clean code is not written by following a set of rules. You don\'t become a software craftsman by learning a list of heuristics. Professionalism and craftsmanship come from values that drive disciplines." - Robert C. Martin',
            'goals' => 'Terus berkembang dalam dunia teknologi, berkontribusi pada proyek-proyek yang memberikan dampak positif, dan berbagi knowledge dengan komunitas developer. Passionate dalam menciptakan user experience yang exceptional dan solusi yang scalable.',
            'contact' => [
                'email' => 'muhammad.eka@example.com',
                'github' => 'https://github.com/muhammadeka',
                'linkedin' => 'https://linkedin.com/in/muhammad-eka-nur-fauzi'
            ],
            'experience' => [
                [
                    'position' => 'Senior Full Stack Developer',
                    'company' => 'Tech Solutions Inc.',
                    'period' => '2022 - Present',
                    'description' => 'Lead developer untuk berbagai proyek web application menggunakan Laravel dan Vue.js'
                ],
                [
                    'position' => 'Web Developer',
                    'company' => 'Digital Agency',
                    'period' => '2020 - 2022', 
                    'description' => 'Mengembangkan website dan aplikasi web untuk klien dari berbagai industri'
                ]
            ],
            'projects' => [
                [
                    'name' => 'E-Commerce Platform',
                    'tech' => 'Laravel, Vue.js, MySQL',
                    'description' => 'Full-featured e-commerce platform dengan payment gateway integration'
                ],
                [
                    'name' => 'Task Management System',
                    'tech' => 'Laravel, React, PostgreSQL',
                    'description' => 'Collaborative task management system untuk tim development'
                ],
                [
                    'name' => 'API Documentation Tool',
                    'tech' => 'Laravel, Swagger, Docker',
                    'description' => 'Tool untuk generate dan maintain API documentation secara otomatis'
                ]
            ]
        ];

        return view('about', compact('profile'));
    }

    /**
     * Get profile data as JSON (for API endpoints)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileData()
    {
        $profile = [
            'name' => 'Muhammad Eka Nur Fauzi',
            'title' => 'Full Stack Developer & Creative Technologist',
            'skills' => [
                'PHP & Laravel',
                'JavaScript & Vue.js',
                'MySQL & PostgreSQL',
                'HTML5 & CSS3',
                'Git & GitHub',
                'RESTful API',
                'Bootstrap & Tailwind',
                'Docker'
            ],
            'contact' => [
                'email' => 'muhammad.eka@example.com',
                'github' => 'https://github.com/muhammadeka',
                'linkedin' => 'https://linkedin.com/in/muhammad-eka-nur-fauzi'
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $profile
        ]);
    }

    /**
     * Download CV/Resume
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadCV()
    {
        $filePath = storage_path('app/public/cv/muhammad-eka-nur-fauzi-cv.pdf');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'Muhammad-Eka-Nur-Fauzi-CV.pdf');
        }
        
        return redirect()->back()->with('error', 'CV file not found.');
    }
}