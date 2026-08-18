@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="w-100 overflow-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
        <ul class="pagination pagination-custom justify-content-center flex-nowrap mb-0 gap-1 gap-md-2 pb-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm" aria-hidden="true">
                        <i class="fas fa-chevron-left" style="font-size: 0.8rem;"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-left" style="font-size: 0.8rem;"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-medium" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm" aria-hidden="true">
                        <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
    <style>
        .pagination-custom .page-link {
            width: 34px;
            height: 34px;
            font-size: 0.85rem;
            color: #475569;
            border: none;
            background-color: #fff;
            transition: all 0.2s ease-in-out;
            padding: 0;
        }
        @media (min-width: 768px) {
            .pagination-custom .page-link {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
        .pagination-custom .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-teal);
            transform: translateY(-2px);
        }
        .pagination-custom .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-dark));
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(130, 168, 199, 0.4) !important;
        }
        .pagination-custom .page-item.disabled .page-link {
            background-color: #f8fafc;
            color: #cbd5e1;
        }
    </style>
@endif
