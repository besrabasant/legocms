@php
$appConfig = [
    'locale' => \legocmsLocale()
];
@endphp
<script type="text/javascript">window.{{ \config('legocms.js_namespace') }}.APP = @json($appConfig);</script>