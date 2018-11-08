<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>ニアステ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta property="og:title" content="ニアステ">
    <meta property="og:type" content="website">
    <meta property="og:description" content="SAやPAの最寄り駅を出します。">
    <meta property="og:url" content="{{ route('app') }}">
    <meta property="og:site_name" content="find station">
    <meta property="og:image" content="{{ asset('images/ogimage.jpg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru" rel="stylesheet">
</head>
    <body>
        <div id="app">
            <area-info-component></area-info-component>
        </div>
        <div class="footer">Copyright &copy; ニアステ <a href="http://icchy-profile.site">製作者サイト</a></div>
    </body>
<script src="{{ asset('js/app.js') }}"></script>

</html>
