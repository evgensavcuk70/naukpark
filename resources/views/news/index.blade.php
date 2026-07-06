{{-- Сторінка списку новин з пошуком і фільтрами. --}}
@extends('layouts.app')

@section('body-class', 'class="all-news-page-body"')

@section('meta')
    @php
        $pageTitle = $lang === 'en'
            ? 'News & Announcements — Science Park "Polissia University"'
            : 'Новини та анонси — Науковий парк «Поліський університет»';
        $pageDesc = $lang === 'en'
            ? 'Latest news, events and announcements from Science Park Polissia University.'
            : 'Останні новини, події та анонси Наукового парку «Поліський університет».';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:image" content="{{ $siteUrl . '/images/logo_dark_bg.png' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('news.index') }}">
    <link rel="canonical" href="{{ route('news.index') }}">

    {!! '<script type="application/ld+json">' . json_encode($schemaCollection, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . '</script>' !!}
@endsection

@push('styles')
<style>
    .news-page-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: 'Inter', sans-serif; }
    .filter-form { display:flex; flex-wrap:wrap; gap:15px; background:#fff; padding:20px; border-radius:12px; margin-bottom:30px; align-items:flex-end; border:1px solid rgba(4,44,34,.1); box-shadow:0 4px 15px rgba(4,44,34,.05); }
    .filter-group { display:flex; flex-direction:column; gap:5px; flex:1; min-width:200px; }
    .filter-group label { color:#042C22; font-weight:600; font-family:'Montserrat',sans-serif; font-size:.9rem; }
    .filter-group input, .filter-group select { padding:10px; border:1px solid #cbd5e1; border-radius:6px; font-size:.95rem; outline:none; font-family:inherit; }
    .filter-buttons { display:inline-flex; align-items:center; gap:15px; height:42px; }
    .btn-filter { background:#0A4A33; color:#fff; border:none; padding:0 25px; border-radius:6px; font-weight:bold; cursor:pointer; height:42px; font-family:'Montserrat',sans-serif; font-size:.95rem; transition:background .3s; }
    .btn-filter:hover { background:#042C22; }
    .btn-reset { background:#64748b; color:#fff; text-decoration:none; padding:0 25px; border-radius:6px; font-weight:bold; height:42px; line-height:42px; font-family:'Montserrat',sans-serif; font-size:.95rem; display:inline-flex; align-items:center; transition:background .3s; }
    .btn-reset:hover { background:#475569; }
    .pagination { display:flex; justify-content:center; gap:8px; margin-top:40px; flex-wrap:wrap; }
    .pagination a, .pagination span { padding:8px 16px; border:1px solid #cbd5e1; border-radius:6px; text-decoration:none; color:#1e293b; font-weight:600; transition:all .3s; }
    .pagination .active { background:#0A4A33; color:#fff; border-color:#0A4A33; }
    body.all-news-page-body { background-color:#F3EBDD !important; }
    .news-page-container h1 { color:#042C22; font-family:'Montserrat',sans-serif; font-weight:800; font-size:2.2rem; }
    .news-card { background:#fff !important; border:none !important; border-radius:12px !important; box-shadow:0 6px 18px rgba(4,44,34,.06) !important; display:flex; flex-direction:column; overflow:hidden; position:relative; }
    .news-card h3 a { color:#1F2937 !important; font-family:'Montserrat',sans-serif; font-weight:700; text-decoration:none; transition:color .3s; }
    .news-card h3 a:hover { color:#0A4A33 !important; }
</style>
@endpush

@section('content')
<div class="news-page-container">
    <h1>{{ $lang === 'en' ? 'News & Announcements' : 'Новини та анонси Наукового парку' }}</h1>

    <form method="GET" action="{{ route('news.index') }}" class="filter-form">
        <div class="filter-group">
            <label>{{ $lang === 'en' ? 'Search text' : 'Пошук за текстом' }}</label>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="{{ $lang === 'en' ? 'Keywords...' : 'Введіть заголовок або текст...' }}">
        </div>

        <div class="filter-group">
            <label>{{ $lang === 'en' ? 'Category' : 'Категорія' }}</label>
            <select name="category_id">
                <option value="0">-- {{ $lang === 'en' ? 'All Categories' : 'Усі категорії' }} --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId === $cat->id ? 'selected' : '' }}>
                        {{ $lang === 'en' ? $cat->name_en : $cat->name_ua }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>{{ $lang === 'en' ? 'Year' : 'Рік публікації' }}</label>
            <select name="year">
                <option value="0">-- {{ $lang === 'en' ? 'All Years' : 'Усі роки' }} --</option>
                @foreach($years as $y)
                    @if($y)
                        <option value="{{ $y }}" {{ $year === (int)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="filter-buttons">
            <button type="submit" class="btn-filter">{{ $lang === 'en' ? 'Filter' : 'Фільтрувати' }}</button>
            <a href="{{ route('news.index') }}" class="btn-reset">{{ $lang === 'en' ? 'Reset' : 'Скинути' }}</a>
        </div>
    </form>

    <div class="news-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:30px;">
        @forelse($newsList as $item)
            <article class="news-card">
                @if($item->is_pinned)
                    <span style="position:absolute;top:12px;left:12px;background:#10b981;color:white;padding:4px 10px;border-radius:20px;font-size:.75rem;font-weight:bold;z-index:5;box-shadow:0 2px 4px rgba(0,0,0,.1);">
                        📌 {{ $lang === 'en' ? 'Pinned' : 'Закріплено' }}
                    </span>
                @endif

                <div style="height:200px;overflow:hidden;background:#cbd5e1;">
                    <img src="{{ $item->image_url }}" style="width:100%;height:100%;object-fit:cover;"
                         onerror="this.src='{{ asset('images/photo1.jpg') }}'">
                </div>

                <div style="padding:20px;display:flex;flex-direction:column;flex-grow:1;">
                    <h3 style="margin:0 0 12px 0;font-size:1.25rem;line-height:1.35;">
                        <a href="{{ route('news.show', $item->slug) }}">
                            {{ $item->getTitle($lang) }}
                        </a>
                    </h3>
                    <p style="font-size:.92rem;margin:0 0 20px 0;flex-grow:1;color:#1F2937;">
                        {{ $item->getShortDesc($lang, 140) }}
                    </p>
                    <time style="color:#6b7280;font-size:.85rem;">{{ $item->getFormattedDate($lang) }}</time>
                </div>
            </article>
        @empty
            <p style="grid-column:1/-1;text-align:center;color:#64748b;padding:50px 0;font-weight:500;font-size:1.1rem;background:white;border-radius:12px;border:1px dashed #cbd5e1;">
                {{ $lang === 'en' ? 'No news found matching your criteria.' : 'Нічого не знайдено за вашим запитом.' }}
            </p>
        @endforelse
    </div>

    {{ $newsList->onEachSide(1)->links('pagination.site') }}
</div>
@endsection
