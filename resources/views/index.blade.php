<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>find station</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta property="og:title" content="find station">
    <meta property="og:type" content="website">
    <meta property="og:description" content="SAやPAの最寄り駅を出します。">
    <meta property="og:url" content="{{ route('app') }}">
    <meta property="og:site_name" content="find station">
    <meta property="og:image" content="{{ asset('images/ogimage.jpg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|EB+Garamond" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
    <body>
        <div id="app">
            <area-info-component></area-info-component>
        </div>
        <div class="footer">
            フッター
        </div>
    </body>
<script src="{{ asset('js/app.js') }}"></script>

</html>
