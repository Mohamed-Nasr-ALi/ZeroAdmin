<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.links_header')
</head>
<body>
@include('layouts.app_page_body')
@include('layouts.links_footer')
</body>
</html>
