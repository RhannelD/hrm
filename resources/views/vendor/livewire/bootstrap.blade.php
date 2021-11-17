<div>
    @if ($paginator->hasPages())
        <nav style="max-height: 35px;">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">
                            <i class="fas fa-chevron-circle-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" dusk="previousPage" class="page-link" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">
                            <i class="fas fa-chevron-circle-left"></i>
                        </button>
                    </li>
                @endif

                {{-- Pagination Elements --}}

                @if ($paginator->lastPage() > 0)
                    @php
                        $currentpage = $paginator->currentPage();
                        $firstpage = $currentpage;
                        $lastpage = $currentpage;
                        $numOfPagination = 5;
                    @endphp
                    @while ($firstpage != 1 || $lastpage != $paginator->lastPage())
                        @if ($numOfPagination <= 1)
                            @break
                        @endif
                        @if ($lastpage < $paginator->lastPage())
                            @php
                                $lastpage++;
                                $numOfPagination--;
                            @endphp
                        @endif
                        @if ($numOfPagination <= 1)
                            @break
                        @endif
                        @if ($firstpage > 1)
                            @php
                                $firstpage--;
                                $numOfPagination--;
                            @endphp
                        @endif
                    @endwhile
                @endif

                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page >= $firstpage && $page <= $lastpage)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" wire:key="paginator-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item" wire:key="paginator-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" dusk="nextPage" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">
                            <i class="fas fa-chevron-circle-right"></i>
                        </button>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">
                            <i class="fas fa-chevron-circle-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
