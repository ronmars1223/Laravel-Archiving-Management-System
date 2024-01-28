@if ($paginator->hasPages())
    <div class="d-flex justify-content-center">
        @if ($paginator->onFirstPage())
            <button disabled="disabled" class='btn btn-sm' style="background-color: #4e73df; color: white; margin-left: 1px;">Prev</button>
        @else
            <button class="btn btn-sm" style="background-color: #4e73df; color: white; margin-left: 1px;" wire:click='previousPage'>Prev</button>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="btn btn-secondary btn-sm" style="background-color: #4e73df; color: white; margin-left: 1px;" wire:click='gotoPage({{ $page }})'>
                            {{ $page }}</button>
                    @else
                        <button class="btn btn-sm" style="background-color: #4e73df; color: white; margin-left: 1px;" wire:click='gotoPage({{ $page }})'>
                            {{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <button class="btn btn-sm" style="background-color: #4e73df; color: white; margin-left: 1px;" wire:click='nextPage'>Next</button>
        @else
            <button class="btn btn-sm" style="background-color: #4e73df; color: white; margin-left: 1px;" disabled>Next</button>
        @endif
    </div>
@endif
