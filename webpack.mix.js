const mix = require('laravel-mix');

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

//Admin css
mix.setPublicPath('public');
mix.js('resources/js/custom.js', 'public/assets/js').version();
mix.sass('resources/sass/style.scss', 'public/assets/css').version();
mix.sass('resources/sass/franchisees.scss', 'public/assets/css');
mix.sass('resources/sass/femployees.scss', 'public/assets/css');

//Frontend Css
mix.sass('resources/sass/frontend/front.scss', 'public/assets/frontend/css').version();


//admin responsive
mix.sass('resources/sass/responsive.scss', 'public/assets/css').version();
