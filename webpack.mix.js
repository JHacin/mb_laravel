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

mix
    .copyDirectory('resources/img', 'public/img')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/scss/app.scss', 'public/css')
    .browserSync({
        ui: false,
        proxy: process.env.MIX_BROWSERSYNC_PROXY,
        port: process.env.MIX_BROWSERSYNC_PORT,
        notify: false,
        open: false,
    });
