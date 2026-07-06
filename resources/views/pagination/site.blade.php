{{-- Пагінація на основі стандартного Laravel-пагінатора (LengthAwarePaginator).
     Розмітка кастомна (під наявні CSS-класи .pagination / .pagination a / .pagination .active),
     але вся логіка сторінок, URL-адрес і "вікна" сторінок
     береться з бібліотеки, а не рахується вручну.

     Примітка: у LengthAwarePaginator немає методу elements() - це метод
     старого Presenter API (Laravel 5.x). "Вікно" сторінок треба будувати
     через Illuminate\Pagination\UrlWindow::make($paginator) - цей метод
     вже сам повертає готовий масив (сам викликає ->get() всередині). --}}
@php
    $elements = \Illuminate\Pagination\UrlWindow::make($paginator);
@endphp
@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">&raquo;</a>
        @else
            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">&raquo;</span>
        @endif
    </nav>
@endif
