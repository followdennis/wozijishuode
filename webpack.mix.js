let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/assets/js/app.js', 'public/js')
mix
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.js('resources/assets/js/wechat.js','public/js');
mix.js('resources/assets/js/article.js','public/js');

//安装jquery
mix.js('resources/assets/vendor/jquery/src/jquery','public/vendor/jquery');

