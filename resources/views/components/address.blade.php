<div class="adresses-flex {{ $class ?? '' }}">
    <div class="adresses-info">
        <p class="adress-item">{{ $title }}</p>
        <p class="adress-ex"><input type="text" disabled value="{{ $value }}"></p>
        @if(isset($copy))
            <div class="copy"><label for="cop5" class="label-svg">copy</label></div>
        @endif
    </div>
</div>
