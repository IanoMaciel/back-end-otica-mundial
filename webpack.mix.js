const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
   .browserSync({
        proxy: 'http://127.0.0.1:8000/', // URL do Laravel
        files: [
            'app/**/*.php',
            'resources/views/**/*.blade.php',
            'resources/js/**/*.js',
            'public/**/*.css',
            'routes/**/*.php'
        ],
        open: false,
        notify: false,
    });
