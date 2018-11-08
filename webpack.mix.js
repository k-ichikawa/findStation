const mix = require('laravel-mix');

mix.copy('resources/css', 'public/css');
mix.copy('resources/images', 'public/images');

mix.js('resources/js/app.js', 'public/js');