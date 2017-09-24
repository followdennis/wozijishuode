const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js');

    // bootstrap-switch
    mix.less('../vendor/bootstrap-switch/src/less/bootstrap3/build.less', 'public/vendor/bootstrap-switch/bootstrap-switch.css')
    .coffee('../vendor/bootstrap-switch/src/coffee/bootstrap-switch.coffee', 'public/vendor/bootstrap-switch/bootstrap-switch.js');

});
