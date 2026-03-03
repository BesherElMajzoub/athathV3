<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function index(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Disallow: /admin',
            'Disallow: /admin/*',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /password/*',
            'Disallow: /api/*',
            '',
            'Sitemap: ' . url('/sitemap.xml'),
        ]);

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
