const mix = require('laravel-mix');

mix
  .copyDirectory('resources/img', 'public/img')
  .ts('resources/js/app.ts', 'public/js')
  .ts('resources/js/giftee_form.ts', 'public/js')
  .ts('resources/js/cat-details-gallery.ts', 'public/js');

mix.ts('resources/js/react/cat-sponsor-form.tsx', 'public/js').react();

mix.postCss('resources/css/app.css', 'public/css', [require('tailwindcss')]);

if (mix.inProduction()) {
  mix.version();
} else {
  mix.browserSync({
    ui: false,
    host: process.env.MIX_BROWSERSYNC_HOST,
    proxy: process.env.MIX_BROWSERSYNC_PROXY,
    notify: false,
    open: process.env.MIX_BROWSERSYNC_OPEN === 'true',
  });
}
