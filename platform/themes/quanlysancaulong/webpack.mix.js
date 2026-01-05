let mix = require('laravel-mix')
const webpack = require('webpack')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'platform/themes/' + directory
const dist = 'public/themes/' + directory

mix
    .sass(source + '/assets/sass/style.scss', dist + '/css')
    // Shared site bundle
    .js(source + '/assets/js/main.ts', dist + '/js/main.js')
    // Booking page bundle
    .js(source + '/assets/js/pages/booking.ts', dist + '/js/booking.js')
    // Personal info page bundle
    .js(source + '/assets/js/pages/personal-info.ts', dist + '/js/personal-info.js')
    // Checkout page bundle
    .js(source + '/assets/js/pages/checkout.ts', dist + '/js/checkout.js')
    .vue(3)
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: 'ts-loader',
                    options: {
                        appendTsxSuffixTo: [/\.vue$/],
                    },
                    exclude: /node_modules/,
                },
            ],
        },
        resolve: {
            extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
        },
    });

// Luôn copy file build sang thư mục public của theme để Theme::asset()->usePath() dùng được
mix.copy(dist + '/css/style.css', source + '/public/css')
   .copy(dist + '/js/main.js', source + '/public/js')
   .copy(dist + '/js/booking.js', source + '/public/js')
   .copy(dist + '/js/personal-info.js', source + '/public/js')
   .copy(dist + '/js/checkout.js', source + '/public/js')
