{{-- Головна сторінка сайту. --}}
@extends('layouts.app')

@section('meta')
    @php
        $ogTitle = app()->getLocale() === 'ua'
            ? 'Науковий парк «Поліський університет»'
            : 'Science Park "Polissia University"';
        $ogDesc  = app()->getLocale() === 'ua'
            ? 'Інноваційна платформа для розвитку науки, технологій та підприємництва. Об\'єднуємо науку, освіту, бізнес та громади.'
            : 'Innovative platform for the development of science, technology, and entrepreneurship. Uniting science, education, business, and communities.';
        $ogImage = $siteUrl . '/images/logo_dark_bg.png';
    @endphp

    <title>{{ $ogTitle }}</title>
    <meta name="description" content="{{ $ogDesc }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $siteUrl }}/">
    <link rel="canonical" href="{{ $siteUrl }}/">

    {!! '<script type="application/ld+json">' . json_encode($schemaOrg, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PRETTY_PRINT) . '</script>' !!}
@endsection

@section('content')

    <section class="hero-section">
        <div class="container hero-container">

            <div class="hero-text-block">
                @if(app()->getLocale() === 'ua')
                    <h1 class="hero-title">Наука, що працює</h1>
                    <h2 class="hero-subtitle">для громад, бізнесу та довкілля</h2>
                    <p class="hero-description">
                        Об'єднуємо науку, освіту, бізнес та громади для створення інноваційних рішень і сталого розвитку Полісся та України.
                    </p>
                    <div class="hero-buttons">
                        <a href="#about" class="btn btn-primary">Дізнатись більше</a>
                        <a href="#news" class="btn btn-secondary">Останні новини</a>
                    </div>
                @else
                    <h1 class="hero-title">Science that works</h1>
                    <h2 class="hero-subtitle">for communities, business and environment</h2>
                    <p class="hero-description">
                        Combining science, education, business, and communities to create innovative solutions and sustainable development of Polissia and Ukraine.
                    </p>
                    <div class="hero-buttons">
                        <a href="#about" class="btn btn-primary">Learn More</a>
                        <a href="#news" class="btn btn-secondary">Latest News</a>
                    </div>
                @endif
            </div>

            <div class="hero-slider-block">
                <div class="slider-wrapper">
                    @forelse($slides as $index => $slide)
                        <div class="slide {{ $index === 0 ? 'active' : '' }}">
                            <div class="collage-mask" style="background-image: url('{{ $slide->image_url }}');"></div>
                        </div>
                    @empty
                        <div class="slide active">
                            <div class="collage-mask" style="background-image: url('{{ asset('images/photo1.jpg') }}');"></div>
                        </div>
                    @endforelse
                </div>

                <button class="slider-arrow prev-arrow">&#10216;</button>
                <button class="slider-arrow next-arrow">&#10217;</button>

                <div class="slider-dots">
                    @foreach($slides as $index => $slide)
                        <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            @if(app()->getLocale() === 'ua')
                <div class="about-block">
                    <h2 class="section-title">Інновації для розвитку Полісся та України</h2>
                    <p class="section-text">
                        «Науковий парк «Поліський університет» — це інноваційна платформа для розвитку науки, технологій та підприємництва. Ми об'єднуємо науковців, студентів, бізнес, громади та державні інституції для створення і впровадження сучасних рішень у сферах цифрової трансформації, екології, біоекономіки та сталого розвитку.»
                    </p>
                </div>
                <div class="target-block">
                    <h3 class="target-title">Наша мета</h3>
                    <p class="target-text">
                        «Формування сучасної інноваційної екосистеми, у якій наука, освіта та бізнес спільно створюють цифрові та «зелені» рішення для сталого розвитку Полісся та України.»
                    </p>
                </div>
            @else
                <div class="about-block">
                    <h2 class="section-title">Innovations for the development of Polissia and Ukraine</h2>
                    <p class="section-text">
                        "Science Park «Polissia University» is an innovative platform for the development of science, technology, and entrepreneurship. We unite scientists, students, business, communities, and state institutions to create and implement modern solutions in the fields of digital transformation, ecology, bioeconomy, and sustainable development."
                    </p>
                </div>
                <div class="target-block">
                    <h3 class="target-title">Our Goal</h3>
                    <p class="target-text">
                        "Forming a modern innovative ecosystem in which science, education, and business jointly create digital and 'green' solutions for the sustainable development of Polissia and Ukraine."
                    </p>
                </div>
            @endif
        </div>
    </section>

    <section id="activity" class="activity-section">
        <div class="container">
            <div class="section-divider">
                <span>{{ __('menu.activities') }}</span>
            </div>

            <div class="activities-grid">
                @forelse($activities as $act)
                    @php $iconFile = $act->icon_path ?: 'icon1.svg'; @endphp
                    <div class="activity-card">
                        <div class="activity-icon">
                            <img src="{{ asset('images/' . $iconFile) }}" alt="Icon" width="45" height="45">
                        </div>
                        <h3 class="activity-card-title">{{ $act->getTitle($lang) }}</h3>
                        <p class="activity-card-text"><span>{{ $act->getDescription($lang) }}</span></p>
                        <button type="button" class="activity-card-toggle" aria-expanded="false"
                            data-more="{{ $lang === 'ua' ? 'Детальніше' : 'Read more' }}"
                            data-less="{{ $lang === 'ua' ? 'Згорнути' : 'Show less' }}">
                            <span class="toggle-label">{{ $lang === 'ua' ? 'Детальніше' : 'Read more' }}</span>
                            <span class="toggle-arrow" aria-hidden="true">▾</span>
                        </button>
                    </div>
                @empty
                    <p style="text-align:center;width:100%;color:#64748b;">Loading...</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="capabilities" class="capabilities-section">
        <div class="container-caps">
            <div class="caps-header">
                <span class="decor-line"></span>
                <h2 class="caps-main-title">{{ __('menu.capabilities') }}</h2>
                <span class="decor-line"></span>
            </div>

            <div class="capabilities-row">
                @forelse($capabilities as $cap)
                    <div class="cap-single-card">
                        <div class="cap-icon-wrapper">
                            <img src="{{ $cap->icon_url }}" alt="icon" class="cap-svg-img">
                        </div>
                        <p class="cap-card-description">{{ $cap->getDescription($lang) }}</p>
                    </div>
                @empty
                    <p style="text-align:center;width:100%;color:#64748b;">Loading...</p>
                @endforelse
            </div>
        </div>
    </section>

    <section id="news" class="news-section">
        <div class="container-news">
            <div class="news-top-header">
                <h2 class="news-section-title">{{ __('menu.news') }}</h2>
                <a href="{{ route('news.index') }}" class="all-news-link">
                    {{ $lang === 'ua' ? 'Усі новини →' : 'All news →' }}
                </a>
            </div>

            <div class="news-grid">
                @forelse($latestNews as $item)
                    <article class="news-card" style="position:relative;display:flex;flex-direction:column;">
                        @if($item->is_pinned)
                            <span class="pinned-badge" style="position:absolute;top:12px;left:12px;background:#10b981;color:white;padding:4px 10px;border-radius:20px;font-size:.75rem;font-weight:bold;z-index:5;box-shadow:0 2px 4px rgba(0,0,0,.15);">
                                📌 {{ $lang === 'ua' ? 'Закріплено' : 'Pinned' }}
                            </span>
                        @endif

                        <div class="news-img-box">
                            <img src="{{ $item->image_url }}" alt="News Image">
                        </div>

                        <div class="news-card-content" style="display:flex;flex-direction:column;flex-grow:1;padding:15px;">
                            <h3 class="news-card-title" style="margin-top:0;margin-bottom:10px;">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    {{ $item->getTitle($lang) }}
                                </a>
                            </h3>
                            <p class="news-card-desc" style="font-size:.9rem;color:#475569;line-height:1.5;margin:0 0 15px 0;flex-grow:1;">
                                {{ $item->getShortDesc($lang) }}
                            </p>
                            <time class="news-card-date" style="font-size:.85rem;color:#94a3b8;margin-top:auto;">
                                {{ $item->getFormattedDate($lang) }}
                            </time>
                        </div>
                    </article>
                @empty
                    <p style="text-align:center;color:#64748b;grid-column:span 3;padding:4px 0;">
                        {{ $lang === 'ua' ? 'Свіжі публікації готуються до випуску...' : 'Fresh publications are being prepared for release...' }}
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    @php
        $contactEmail   = $settings['contact_email']    ?? 'naukpark@polissiauniver.edu.ua';
        $contactAddress = $lang === 'en'
            ? ($settings['contact_address_en'] ?? '7 Staryi Bulvar, Zhytomyr, Zhytomyr Oblast, Ukraine, 10008')
            : ($settings['contact_address_ua'] ?? '10008, Україна, Житомирська обл., м. Житомир, Старий бульвар, 7');
        $socialFb  = $settings['social_facebook'] ?? 'https://www.facebook.com/polissia.univer/';
        $socialLn  = $settings['social_linkedin'] ?? 'https://ua.linkedin.com/school/polisia-national-university/';
        $socialTg  = $settings['social_telegram'] ?? 'https://t.me/polissia_univer';
    @endphp

    <footer id="contacts" class="site-footer">
        <div class="container-footer">

            <div class="footer-left-side">
                <div class="footer-text-block">
                    <h2 class="footer-moto">{{ $lang === 'ua' ? 'Будуємо майбутнє разом' : 'Building the future together' }}</h2>
                    <p class="footer-subtext">
                        {{ $lang === 'ua'
                            ? 'Долучайтеся до спільноти інноваторів, дослідників, підприємців та всіх, хто прагне змін на краще!'
                            : 'Join the community of innovators, researchers, entrepreneurs and everyone who strives for changes for the better!' }}
                    </p>
                </div>
            </div>

            <div class="footer-center-side">
                <div class="contact-row">
                    <span class="contact-icon email-icon">✉</span>
                    <a href="mailto:{{ $contactEmail }}" class="contact-link">{{ $contactEmail }}</a>
                </div>
                <div class="contact-row">
                    <span class="contact-icon geo-icon">📍</span>
                    <span class="contact-text">{{ $contactAddress }}</span>
                </div>
                <div class="footer-socials">
                    @if($socialFb)
                        <a href="{{ $socialFb }}" target="_blank" rel="noopener noreferrer" class="social-link-icon">
                            <img src="{{ asset('images/fb.svg') }}" alt="Facebook" class="social-img">
                        </a>
                    @endif
                    @if($socialLn)
                        <a href="{{ $socialLn }}" target="_blank" rel="noopener noreferrer" class="social-link-icon">
                            <img src="{{ asset('images/ln.svg') }}" alt="LinkedIn" class="social-img">
                        </a>
                    @endif
                    @if($socialTg)
                        <a href="{{ $socialTg }}" target="_blank" rel="noopener noreferrer" class="social-link-icon">
                            <img src="{{ asset('images/tg.svg') }}" alt="Telegram" class="social-img">
                        </a>
                    @endif
                </div>
            </div>

            <div class="footer-right-side">
                <div class="qr-code-holder">
                    <img src="{{ asset('images/qr_code.png') }}"
                         alt="QR Code"
                         onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://polissiauniver.edu.ua'">
                </div>
            </div>

        </div>
    </footer>

@endsection

@push('scripts')
<script>
(function () {
    var header   = document.querySelector('.site-header');
    var observer = new MutationObserver(function () {
        document.body.classList.toggle('header-is-fixed', header.classList.contains('header-fixed'));
    });
    if (header) observer.observe(header, { attributes: true, attributeFilter: ['class'] });
})();
</script>
@endpush