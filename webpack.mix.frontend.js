let mix = require('laravel-mix');

// 🎚️ Base config
const config = {
    path: './src/assetbundles/frontend/',
}

// Front-end assets
mix.js(config.path + 'src/js/app.js', config.path + 'dist/app.js').extract(['htmx.org','alpinejs'])
    .sass(config.path + 'src/scss/app.scss', config.path + 'dist/')
    .copy(config.path + 'src/fonts/*', config.path + 'dist/')
    .options({ processCssUrls: false })
