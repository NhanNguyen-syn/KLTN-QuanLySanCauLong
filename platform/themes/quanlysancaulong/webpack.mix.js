let mix = require('laravel-mix')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'platform/themes/' + directory
const dist = 'public/themes/' + directory

mix
    .sass(source + '/assets/sass/style.scss', dist + '/css')
    .ts(source + '/assets/ts/main.ts', dist + '/js')
    .vue({ version: 3 })
    .babelConfig({ plugins: ['@vue/babel-plugin-jsx'] })
    // Always copy compiled assets back to theme public for Theme::asset()->usePath()
    .copy(dist + '/css/style.css', source + '/public/css')
    .copy(dist + '/js/main.js', source + '/public/js')
