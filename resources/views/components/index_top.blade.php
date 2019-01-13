<div class="mB-20">
@for($i = 0; $i < count($indexes); $i++)
    @if($i < count($indexes) - 1)
        <span>{{ $indexes[$i] }}</span>
        |
    @else
        <span class="c-orange-800">{{ $indexes[$i] }} </span>
    @endif
@endfor
</div>