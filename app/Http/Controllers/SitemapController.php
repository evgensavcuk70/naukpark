<?php

// Контролер генерації sitemap.xml.
namespace App\Http\Controllers;

use App\Models\News;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            [
                'loc'        => url('/'),
                'changefreq' => 'weekly',
                'priority'   => '1.0',
            ],
            [
                'loc'        => route('news.index'),
                'changefreq' => 'daily',
                'priority'   => '0.8',
            ],
        ];

        $newsList = News::published()
            ->select('slug', 'published_at', 'updated_at')
            ->orderByDesc('published_at')
            ->get();

        foreach ($newsList as $n) {
            $lastmod = ($n->updated_at ?? $n->published_at)->format('Y-m-d');

            $urls[] = [
                'loc'        => route('news.show', $n->slug),
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.7',
            ];
        }

        return response()->view('sitemap', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
