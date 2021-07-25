const mix = require('laravel-mix');

mix
    .copyDirectory('resources/img', 'public/img')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .js('resources/js/giftee_form.js', 'public/js')
    .sass('resources/scss/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.browserSync({
        ui: false,
        proxy: process.env.MIX_BROWSERSYNC_PROXY,
        port: process.env.MIX_BROWSERSYNC_PORT,
        notify: false,
        open: false,
    });
}
