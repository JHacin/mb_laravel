const mix = require('laravel-mix');

mix
  .copyDirectory('resources/img', 'public/img')
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/giftee_form.js', 'public/js')
  .js('resources/js/cat-details-gallery.js', 'public/js');

mix.js('resources/js/react/cat-sponsor-form.jsx', 'public/js').react();

mix.postCss('resources/css/app.css', 'public/css', [require('tailwindcss')]);

if (mix.inProduction()) {
  mix.version();
} else {
  mix.browserSync({
    ui: false,
    proxy: process.env.MIX_BROWSERSYNC_PROXY,
    port: process.env.MIX_BROWSERSYNC_PORT,
    notify: false,
    open: process.env.MIX_BROWSERSYNC_OPEN === 'true',
  });
}
