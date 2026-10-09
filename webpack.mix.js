const mix = require('laravel-mix')
const path = require('path')
const config = require('./webpack.config')

const alias = {
    '@': path.resolve(__dirname, 'resources/js'),
};

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 //TO-DO SVG ICON MODIFICATION

mix.webpackConfig(config)

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .alias(alias)
    .options({
      processCssUrls: false,
      postCss: [
        require('autoprefixer'),
      ],
    });
