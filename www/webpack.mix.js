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
        presets: [
            ['@babel/preset-env', {
                targets: "> 0.25%, not dead",
                useBuiltIns: "usage",
                corejs: 3
            }]
        ]
    })

if (mix.inProduction()) {
    mix.version()
        .minify('public/js/app.js')
        .minify('public/css/app.css');
}
