let mix = require("laravel-mix");

mix.setPublicPath('public');
mix.sass('resources/assets/sass/imageuploader.scss', 'public/css/acl.css');

mix.scripts([
    'resources/assets/js/delete_data.js',
    'resources/assets/js/store_data.js',
    'resources/assets/js/validation.js',
    // 'resources/assets/js/phone_intl.js',
    // 'resources/assets/js/region.js',
    // 'resources/assets/js/slug.js',
    'resources/assets/js/image_uploader.js',
    // 'resources/assets/js/profile.js',
    // 'resources/assets/js/datatable.js',
    // 'resources/assets/js/custom.js',
   // 'resources/assets/js/select2.js',
    ],
    'public/js/acl.js');