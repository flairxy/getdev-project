const mix = require("laravel-mix");

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

mix
    /* CSS */
    .sass("resources/assets/sass/_scss/main.scss", "public/css/academy.css")

    /* JS */
    .js("resources/assets/js/laravel/app.js", "public/js/laravel.app.js")
    .js("resources/js/app.js", "public/js/vue-app.js")
    .sourceMaps()

    /* Tools */
    .browserSync("localhost:8000")
    .disableNotifications()

    /* Options */
    .options({
        processCssUrls: false
    });
mix.webpackConfig({
    resolve: {
        extensions: [".js", ".vue", ".json"]
    }
});
