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

    // bootstrap-datepicker
    mix.scripts(['../vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
            '../vendor/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js'],
        'public/vendor/bootstrap-datepicker/bootstrap-datepicker.js')
        .less(['../vendor/bootstrap-datepicker/build/build3.less'],
            'public/vendor/bootstrap-datepicker/bootstrap-datepicker.css');
});
