<nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
    <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">
        Showing
        <span class="font-semibold text-gray-900">
            {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} -
            {{ min($paginator->currentPage() * $paginator->perPage(), $paginator->total()) }}
        </span>
        of
        <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
    </span>
    @if ($paginator->hasPages())
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 text-gray-400 bg-white border border-gray-300 rounded-s-lg">Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 h-8 text-gray-500">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100">Next</a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 h-8 text-gray-400 bg-white border border-gray-300 rounded-e-lg">Next</span>
                </li>
            @endif
        </ul>
    @endif
</nav>
