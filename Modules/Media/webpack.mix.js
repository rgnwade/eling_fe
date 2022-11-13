let mix = require('laravel-mix');
let execSync = require('child_process').execSync;

mix.js('Modules/Media/Resources/assets/admin/js/main.js', 'Modules/Media/Assets/admin/js/media.js')
    .sass('Modules/Media/Resources/assets/admin/sass/main.scss', 'Modules/Media/Assets/admin/css/media.css')
    .js('Modules/Media/Resources/assets/vendor/js/main.js', 'Modules/Media/Assets/vendor/js/media.js')
    .sass('Modules/Media/Resources/assets/vendor/sass/main.scss', 'Modules/Media/Assets/vendor/css/media.css')
    .then(() => {
        execSync('npm run rtlcss Modules/Media/Assets/admin/css/media.css Modules/Media/Assets/admin/css/media.rtl.css');
    });
