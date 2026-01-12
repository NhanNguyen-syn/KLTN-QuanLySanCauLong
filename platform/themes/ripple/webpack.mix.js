const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `platform/themes/${directory}`
const dist = `public/themes/${directory}`

mix
    // Compile SASS with expanded output in dev for readable CSS, compressed in production
    .sass(
        `${source}/assets/sass/style.scss`,
        `${dist}/css`,
        { outputStyle: mix.inProduction() ? 'compressed' : 'expanded' }
    )
    .js(`${source}/assets/js/ripple.js`, `${dist}/js`)
    // Disable processing URLs to avoid heavy rewrite of asset paths
    .options({ processCssUrls: false })

if (mix.inProduction()) {
    mix.copy(`${dist}/css/style.css`, `${source}/public/css`)
        .copy(`${dist}/js/ripple.js`, `${source}/public/js`)
}
