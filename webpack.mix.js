const mix = require("laravel-mix");

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

mix.webpackConfig({
    resolve: {
        extensions: [".js", ".vue", ".json"],
        alias: {
            "@": __dirname + "/resources/js",
            Pages: __dirname + "/resources/js/Pages",
            Components: __dirname + "/resources/js/Components"
        }
    }
});

mix.js("resources/js/app.js", "public/js")
    .vue({ version: 2 })
    .css("node_modules/vuetify/dist/vuetify.min.css", "public/css")
    .css("resources/css/app.css", "public/css");
