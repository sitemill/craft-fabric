let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

// 🎚️ Base config
const config = {
    path: './src/assetbundles/frontend/',
}

// Front-end assets
mix.js(config.path + 'src/js/app.js', '.')

mix.sass(config.path + 'src/scss/app.scss', '.')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    })
    .purgeCss({
        safelist: ['text-white'],
        content: ['src/templates/_frontend/**/*.twig']
    })

mix.copy(config.path + 'src/fonts/*', config.path + 'dist/')

mix.browserSync({
    proxy: 'craft-sandbox.local',
    files: [
        'src/assetbundles/frontend/dist/**/*.*',
        'src/templates/_frontend/**/*.twig'
    ]
});

mix.setPublicPath(config.path + 'dist/');