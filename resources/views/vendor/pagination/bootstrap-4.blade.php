
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span>首页</span></li>
        @else
            <li><a class="demo" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span>上一页</span></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="currentpage">{{ $page }}</span></li>
                    @else
                        <li><a class="demo" href="{{ $url }}"><span>{{ $page }}</span></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="demo" href="{{ $paginator->nextPageUrl() }}" rel="next"><span>下一页</span></a></li>
        @else
            <li><span>末页</span></li>
        @endif
    </ul>
@endif