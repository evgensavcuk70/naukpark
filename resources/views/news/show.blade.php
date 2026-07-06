{{-- Сторінка повної новини. --}}
@extends('layouts.app')

@section('body-class', 'class="detail-news-page"')

@section('meta')
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:image" content="{{ $news->image_url }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('news.show', $news->slug) }}">
    <link rel="canonical" href="{{ route('news.show', $news->slug) }}">

    {!! '<script type="application/ld+json">' . json_encode($schemaArticle, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PRETTY_PRINT) . '</script>' !!}
@endsection

@push('styles')
<style>
    body.detail-news-page { background-color:#F4F4F0!important; }
    .detail-container { max-width:900px; margin:50px auto; padding:0 20px; font-family:'Inter',sans-serif; color:#1F2937; }
    .btn-back { display:inline-flex; align-items:center; gap:8px; color:#0A4A33; text-decoration:none; font-weight:bold; font-family:'Montserrat',sans-serif; margin-bottom:25px; transition:color .3s; }
    .btn-back:hover { color:#042C22; }
    .news-meta-info { display:flex; gap:20px; align-items:center; font-size:.9rem; color:#64748b; margin-bottom:15px; font-weight:500; }
    .news-category-badge { background:#E0F2FE; color:#0369a1; padding:4px 12px; border-radius:20px; font-size:.8rem; font-weight:bold; }
    .detail-title { font-family:'Montserrat',sans-serif; font-weight:800; font-size:2.3rem; color:#042C22; line-height:1.25; margin:0 0 25px 0; }
    .main-image-holder { width:100%; height:450px; overflow:hidden; border-radius:12px; box-shadow:0 10px 25px rgba(4,44,34,.08); margin-bottom:35px; }
    .main-image-holder img { width:100%; height:100%; object-fit:cover; }
    .news-full-text { font-size:1.1rem; line-height:1.7; color:#1F2937; margin-bottom:50px; text-align:justify; }
    .news-full-text p { margin:0 0 18px 0; }
    .news-full-text ul, .news-full-text ol { margin:0 0 18px 0; padding-left:24px; }
    .news-full-text img { max-width:100%; height:auto; border-radius:8px; }
    .news-full-text a { color:#0A4A33; }
    .gallery-section-title { font-family:'Montserrat',sans-serif; font-weight:700; font-size:1.4rem; color:#042C22; margin-bottom:20px; border-left:4px solid #C7A84A; padding-left:12px; }
    .news-gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; margin-bottom:50px; }
    .gallery-item { height:140px; overflow:hidden; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,.05); cursor:pointer; transition:transform .3s,box-shadow .3s; }
    .gallery-item img { width:100%; height:100%; object-fit:cover; transition:transform .5s; }
    .gallery-item:hover { transform:translateY(-4px); box-shadow:0 8px 20px rgba(4,44,34,.15); }
    .gallery-item:hover img { transform:scale(1.08); }
    @media (max-width:768px) {
        .detail-container { margin:24px auto; padding:0 14px; }
        .detail-title { font-size:1.5rem!important; }
        .main-image-holder { height:220px!important; }
        .news-full-text { font-size:1rem!important; }
        .news-meta-info { flex-wrap:wrap; gap:10px; }
        .news-gallery-grid { grid-template-columns:repeat(auto-fill,minmax(140px,1fr)); gap:12px; }
        .gallery-item { height:110px; }
    }
    @media (max-width:480px) {
        .detail-title { font-size:1.3rem!important; }
        .news-gallery-grid { grid-template-columns:repeat(2,1fr); }
    }
</style>
@endpush

@section('content')
<div class="detail-container">

    <a href="{{ route('news.index') }}" class="btn-back">
        🡨 {{ $lang === 'en' ? 'All News' : 'Назад до всіх новин' }}
    </a>

    <div class="news-meta-info">
        @if($categoryName)
            <span class="news-category-badge">{{ $categoryName }}</span>
        @endif
        <time>📅 {{ $formattedDate }}</time>
    </div>

    <h1 class="detail-title">{{ $title }}</h1>

    <div class="main-image-holder">
        <img src="{{ $news->image_url }}" alt="{{ $title }}"
             onerror="this.src='{{ asset('images/photo1.jpg') }}'">
    </div>

    <div class="news-full-text">{!! $content !!}</div>

    @if($news->gallery->count())
        <div class="gallery-wrapper">
            <h3 class="gallery-section-title">
                {{ $lang === 'en' ? 'Photo Gallery' : 'Фотогалерея публікації' }}
            </h3>
            <div class="news-gallery-grid">
                @foreach($news->gallery as $photo)
                    <div class="gallery-item"
                         onclick="window.open('{{ asset('images/' . $photo->image_path) }}', '_blank')">
                        <img src="{{ asset('images/' . $photo->image_path) }}"
                             alt="{{ $title }}"
                             onerror="this.src='{{ asset('images/photo1.jpg') }}'">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
