let mix = require('laravel-mix');

const ImageminPlugin     = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin  = require('copy-webpack-plugin');
const imageminMozjpeg    = require('imagemin-mozjpeg');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix.webpackConfig({
    plugins: [
        //Compress images
        new CopyWebpackPlugin([{
            from: 'resources/assets/themes/josh/frontend/images',
            to: 'themes/josh/frontend/images/'
        }]),
        new CopyWebpackPlugin([{
            from: 'resources/assets/themes/josh/backend/img',
            to: 'themes/josh/backend/img/'
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i,
            pngquant: {
                quality: '65-80'
            },
            plugins: [
                imageminMozjpeg({
                    quality: 65,
                    //Set the maximum memory to use in kbytes
                    maxmemory: 1000 * 512
                })
            ]
        })
    ]
});*/

/**
 * Frontend
 */

/*mix.styles([
    'resources/assets/themes/josh/frontend/css/bootstrap.min.css',
    'resources/assets/themes/josh/frontend/css/custom.css',
    'resources/assets/themes/josh/frontend/css/tabbular.css',
    'resources/assets/themes/josh/frontend/css/jquery.circliful.css',
    'resources/assets/themes/josh/frontend/css/owl.carousel.css',
    'resources/assets/themes/josh/frontend/css/owl.theme.css'
], 'public/themes/josh/frontend/css/all.min.css');

mix.styles([
    'resources/assets/themes/josh/frontend/css/bootstrap.min.css',
    'resources/assets/themes/josh/frontend/css/login.css'
], 'public/themes/josh/frontend/css/login.min.css');

mix.styles([
    'resources/assets/themes/josh/frontend/css/bootstrap.min.css',
    'resources/assets/themes/josh/frontend/css/register.css'
], 'public/themes/josh/frontend/css/register.min.css');

mix.copy('resources/assets/themes/josh/frontend/js/jquery.min.js', 'public/themes/josh/frontend/js/jquery.min.js');
mix.copy('resources/assets/themes/josh/frontend/js/bootstrap.min.js', 'public/themes/josh/frontend/js/bootstrap.min.js');

mix.combine([
    'resources/assets/themes/josh/frontend/js/style-switcher.js',
    'resources/assets/themes/josh/frontend/js/raphael.js',
    'resources/assets/themes/josh/frontend/js/livicons-1.4.min.js',
    'resources/assets/themes/josh/frontend/js/josh_frontend.js',
    'resources/assets/themes/josh/frontend/js/jquery.circliful.js',
    'resources/assets/themes/josh/frontend/js/owl.carousel.js',
    'resources/assets/themes/josh/frontend/js/carousel.js',
    'resources/assets/themes/josh/frontend/js/index.js'
], 'public/themes/josh/frontend/js/all.min.js');*/

mix.sass('resources/assets/sass/frontend.scss', 'public/css/frontend.min.css');
mix.sass('resources/assets/sass/backend.scss', 'public/css/backend.min.css');
mix.js('resources/assets/js/backend.js', 'public/js');
mix.js('resources/assets/js/frontend.js', 'public/js');

/**
 * Backend
 */

/*mix.styles([
    'resources/assets/themes/josh/backend/css/app.css',
    'resources/assets/themes/josh/backend/css/tables.css'
], 'public/themes/josh/backend/css/all.min.css');

mix.combine([
    'resources/assets/themes/josh/backend/js/app.js'
], 'public/themes/josh/backend/js/all.min.js');

mix.copyDirectory('resources/assets/themes/josh/backend/fonts', 'public/themes/josh/backend/fonts');*/
mix.copyDirectory('resources/assets/themes/josh/backend/vendors', 'public/themes/josh/backend/vendors');
mix.combine([
    'resources/assets/js/jquery.nestable.js'
], 'public/js/jquery.nestable.min.js');