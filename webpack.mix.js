const mix = require('laravel-mix');
const CleanWebpackPlugin = require('clean-webpack-plugin');

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
mix.disableNotifications();
if (mix.inProduction()) {
    mix.version();
    mix.webpackConfig({
        plugins: [
            new CleanWebpackPlugin('public', {
                exclude: [
                    'favicon.ico',
                    'robots.txt',
                    'web.config',
                    '.htaccess',
                    'mix-manifest.json',
                    'index.php'
                ]
            })
        ]
    });
}
mix.browserSync({
    port: 3000,
    proxy: "anystore_api.test",
    browser: "google chrome"
});
mix.js('resources/js/app.js', 'public/js').autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    wnumb: 'wNumb',
    nouislider: 'noUiSlider',
    snapjs: 'Snap'
})
   .sass('resources/sass/index.scss', 'public/css');

mix.copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/fonts', 'public/fonts');

