<!-- resources/views/components/Card.blade.php -->
<div class="card {{ $class }}">
    <div class="card-content">
        <img src="{{ $image }}" alt="{{ $name }}" class="mx-auto w-[70px] h-[70px] rounded-full" />
        <h2>{{ $name }}</h2>
        <a href="{{ $stakeLink }}"
            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
            target="_blank">STAKE</a>
        <a href="{{ $guideLink }}"
            class="bg-orange-600 w-[120px] h-[35px] inline-block relative pt-[5px] rounded-md hover:scale-105 hover:bg-orange-500 mb-3"
            target="_blank">GUIDE</a>
        @if ($dotActive)
            <div class="dot-active"></div>
        @else
            <div class="dot-inactive"></div>
        @endif
    </div>
</div>
