let mix = require("laravel-mix");
mix.setPublicPath('public');

mix.scripts([
    'resources/assets/js/main.js',
    'Packages/Authentication/public/js/auth.js',
    'Packages/Acl/public/js/acl.js',
], 'public/js/app.js');

mix.styles([
    'Packages/Authentication/public/css/auth.css',
    'Packages/Acl/public/css/acl.css',
], 'public/css/pkg.css');

mix.sass('resources/assets/sass/constant.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/main.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/error.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/media.scss', 'public/css/app.css');

