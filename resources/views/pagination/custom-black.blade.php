@if ($paginator->hasPages())
    <nav>
        <ul class="pagination" style="display: flex; gap: 5px; align-items: center; background: #111; border: 1px solid rgb(254, 198, 228); border-radius: 5px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); justify-content: center; padding: 0 10px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                    <span class="page-btn" style="width:40px;height:40px;background:#111;color:rgb(254,198,228);border:none;display:flex;align-items:center;justify-content:center;opacity:0.5;">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-btn" style="width:40px;height:40px;background:#111;color:rgb(254,198,228);border:none;display:flex;align-items:center;justify-content:center;text-decoration:none;" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-btn" style="background:#111;color:rgb(254,198,228);">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-btn active" style="background:rgb(254,198,228);color:#111;font-weight:700;">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-btn" style="background:#111;color:rgb(254,198,228);text-decoration:none;" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-btn" style="width:40px;height:40px;background:#111;color:rgb(254,198,228);border:none;display:flex;align-items:center;justify-content:center;text-decoration:none;" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                    <span class="page-btn" style="width:40px;height:40px;background:#111;color:rgb(254,198,228);border:none;display:flex;align-items:center;justify-content:center;opacity:0.5;">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
