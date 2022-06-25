@if ($paginator->hasPages())
<div class="row">
    <div class="col-md-12">
        <div class="blog-pagination">
            <nav>
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                    @else
                    <li class="page-item ">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" tabindex="-1"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                    @endif

                    
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                    @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <a class="page-link" href="{{ $url }}">{{ $page }} <span class="sr-only">(current)</span></a>
                    </li>
                    @else
                    <li  ><a href="{{ $url }}">{{ $page }}</a></li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                  






                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-angle-double-right"></i></a>
                    </li>
                    @else
                    <li class="page-item" disabled>
                        <a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>




@endif
