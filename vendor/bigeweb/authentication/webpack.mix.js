const mix = require("laravel-mix");

mix.setPublicPath('public');


mix.sass('resources/assets/sass/auth.scss', 'public/css/auth.css');
mix.sass('resources/assets/sass/profile.scss', 'public/css/auth.css');
mix.sass('resources/assets/sass/media.scss', 'public/css/auth.css');

mix.scripts([
    "resources/assets/js/togglepassword.js"
], 'public/js/auth.js');