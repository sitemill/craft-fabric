let mix = require('laravel-mix');

// 🎚️ Base config
const config = {
    path: './src/assetbundles/library/',
}

// Control panel
mix.js(config.path + 'src/js/library.js', config.path + 'dist/')
    .sass(config.path + 'src/scss/library.scss', config.path + 'dist/')
    .copy(config.path + 'src/fonts/*', config.path + 'dist/')
    .options({ processCssUrls: false })


//Will need this when we put tailwind in...   postCss: [tailwindcss('./tailwind.config.backend.js')]