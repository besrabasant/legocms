@php
/** @param array  $locales */    
@endphp

<div class="listings__translations">
    @foreach ($locales as $locale)
    <span class="listings__translation">
        {{\strtoupper($locale)}}
    </span>
    @endforeach
</div>