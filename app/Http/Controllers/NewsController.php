<?php

// Контролер публічного розділу новин: список, пошук, фільтри, сторінка новини.
namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $lang  = App::getLocale();
        $limit = 6;

        $search     = trim($request->get('search', ''));
        $categoryId = (int) $request->get('category_id', 0);
        $year       = (int) $request->get('year', 0);

        $query = News::published()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at');

        if ($search !== '') {

            $boolQuery = $this->toBooleanFullTextQuery($search);

            if ($boolQuery !== '') {
                $query->where(function ($q) use ($boolQuery) {
                    $q->whereFullText(
                        ['title_ua', 'excerpt_ua', 'content_ua'],
                        $boolQuery,
                        ['mode' => 'boolean']
                    )->orWhereFullText(
                        ['title_en', 'excerpt_en', 'content_en'],
                        $boolQuery,
                        ['mode' => 'boolean']
                    );
                });
            }
        }

        if ($categoryId > 0) {
            $query->where('category_id', $categoryId);
        }

        if ($year > 0) {
            $query->whereYear('published_at', $year);
        }

        $newsList   = $query->paginate($limit)->withQueryString();
        $categories = NewsCategory::orderBy('id')->get();
        $years      = News::published()
            ->selectRaw('YEAR(published_at) as y')
            ->distinct()
            ->orderByDesc('y')
            ->pluck('y');

        $siteUrl = request()->getSchemeAndHttpHost();

        $schemaCollection = [
            '@context'  => 'https://schema.org',
            '@type'     => 'CollectionPage',
            'name'      => $lang === 'en'
                ? 'News & Announcements — Science Park "Polissia University"'
                : 'Новини та анонси — Науковий парк «Поліський університет»',
            'url'       => route('news.index'),
            'publisher' => [
                '@type' => 'Organization',
                'name'  => 'Науковий парк «Поліський університет»',
                'url'   => $siteUrl,
                'logo'  => ['@type' => 'ImageObject', 'url' => $siteUrl . '/images/logo_dark_bg.png'],
            ],
        ];

        return view('news.index', compact(
            'lang', 'newsList', 'categories', 'years',
            'search', 'categoryId', 'year', 'schemaCollection', 'siteUrl'
        ));
    }

    private function toBooleanFullTextQuery(string $search): string
    {
        $words = preg_split('/\s+/u', trim($search)) ?: [];

        $terms = [];
        foreach ($words as $word) {
            $clean = preg_replace('/[+\-<>()~*"@]+/u', '', $word);
            if ($clean !== '') {
                $terms[] = '+' . $clean . '*';
            }
        }

        return implode(' ', $terms);
    }

    public function show(string $slug)
    {
        $lang = App::getLocale();
        $slug = trim($slug);

        $news = News::with(['category', 'gallery'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $title         = $news->getTitle($lang);
        $content       = $news->getContent($lang);
        $metaTitle     = $news->getMetaTitle($lang) . ($lang === 'en' ? ' — News' : ' — Новини');
        $metaDesc      = $news->getMetaDescription($lang);
        $categoryName  = $news->category ? $news->category->getName($lang) : '';
        $formattedDate = $news->getFormattedDate($lang);
        $siteUrl       = request()->getSchemeAndHttpHost();

        $schemaArticle = [
            '@context'      => 'https://schema.org',
            '@type'         => 'NewsArticle',
            'headline'      => $title,
            'description'   => $metaDesc,
            'datePublished' => $news->published_at->toIso8601String(),
            'dateModified'  => ($news->updated_at ?? $news->published_at)->toIso8601String(),
            'image'         => $news->image_url,
            'url'           => route('news.show', $slug),
            'inLanguage'    => $lang === 'en' ? 'en-US' : 'uk-UA',
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => 'Науковий парк «Поліський університет»',
                'url'   => $siteUrl,
                'logo'  => ['@type' => 'ImageObject', 'url' => $siteUrl . '/images/logo_dark_bg.png'],
            ],
        ];
        if ($categoryName) {
            $schemaArticle['articleSection'] = $categoryName;
        }

        return view('news.show', compact(
            'lang', 'news', 'title', 'content', 'metaTitle', 'metaDesc',
            'categoryName', 'formattedDate', 'schemaArticle', 'siteUrl'
        ));
    }
}
