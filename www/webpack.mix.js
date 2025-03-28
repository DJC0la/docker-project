const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
      require('tailwindcss'),
      require('autoprefixer'),
   ])
   .options({
      processCssUrls: false
   })
   .babelConfig({
      presets: ['@babel/preset-env'],
      sourceType: 'module',
   });

if (mix.inProduction()) {
   mix.version();
}