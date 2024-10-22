let mix = require("laravel-mix");
mix.setPublicPath('public');

// mix.styles([
//     'resources/assets/css/main.css'
// ], 'public/css/main.css');


mix.scripts([
    'resources/assets/js/main.js',
], 'public/js/app.js');

mix.sass('resources/assets/sass/main.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/error.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/media.scss', 'public/css/app.css');