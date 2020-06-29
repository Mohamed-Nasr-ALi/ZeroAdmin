<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ZeroCache</title>
        <!-- Styles -->
        <link rel="stylesheet" href="/style/welcome.css">
        @include('layouts.links_header')
    </head>
    <body>
    @include('admin.admin_login.animation')
    @include('layouts.links_footer')
    </body>
</html>
