@props(['route', 'link'])
<a type="button" class="btn btn-sm btn-outline-secondary" href="{{ $route }}">
    @if(isset($link)) {{ $link }} @else <i class="fas fa-th-list"></i> @endif
</a>