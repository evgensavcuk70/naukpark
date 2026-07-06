<?php

// Контролер головної сторінки сайту.
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Capability;
use App\Models\News;
use App\Models\Slide;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        $lang = App::getLocale();

        $slides = Slide::active()->limit(Slide::maxActiveRecords())->get();

        $activities = Activity::visible()->limit(Activity::maxActiveRecords())->get();

        $latestNews = News::published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $capabilities = Capability::ordered()->limit(Capability::maxActiveRecords())->get();

        $settings = SiteSetting::allKeyed();

        $siteUrl = request()->getSchemeAndHttpHost();

        $schemaOrg = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Organization',
            'name'          => 'Науковий парк «Поліський університет»',
            'alternateName' => 'Science Park Polissia University',
            'url'           => $siteUrl,
            'logo'          => $siteUrl . '/images/logo_dark_bg.png',
            'email'         => SiteSetting::get('contact_email', 'naukpark@polissiauniver.edu.ua'),
            'address'       => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => SiteSetting::get('contact_address_ua', 'Старий бульвар, 7'),
                'addressLocality' => 'Житомир',
                'postalCode'      => '10008',
                'addressCountry'  => 'UA',
            ],
            'sameAs' => array_values(array_filter([
                $settings['social_facebook'] ?? 'https://www.facebook.com/polissia.univer/',
                $settings['social_linkedin'] ?? 'https://ua.linkedin.com/school/polisia-national-university/',
                $settings['social_telegram'] ?? 'https://t.me/polissia_univer',
            ])),
        ];

        return view('home', compact(
            'lang',
            'slides',
            'activities',
            'latestNews',
            'capabilities',
            'settings',
            'siteUrl',
            'schemaOrg'
        ));
    }
}
