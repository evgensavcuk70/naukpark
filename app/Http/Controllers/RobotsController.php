<?php

// Контролер генерації robots.txt.
namespace App\Http\Controllers;

class RobotsController extends Controller
{
    public function index()
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /admin/*',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
