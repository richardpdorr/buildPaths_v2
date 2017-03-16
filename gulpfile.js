var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    var bootstrapPath = 'node_modules/bootstrap-sass/assets';
    mix.sass('app.scss')
        .copy(bootstrapPath + '/fonts', 'public/fonts')
        .copy(bootstrapPath + '/javascripts/bootstrap.min.js', 'public/js')

    .scripts([
            'jquery/dist/jquery.min.js',
            // list your other npm packages here
        ],
        'public/js/vendor.js', // 2nd param is the output file
        'node_modules')        // 3rd param is saying "look in /node_modules/ for these scripts"

        .scripts([
            'scripts.js'       // your custom js file located in default location: /resources/assets/js/
        ], 'public/js/app.js') // looks in default location since there's no 3rd param

        .version([             // optionally append versioning string to filename
            'js/vendor.js',    // compiled files will be in /public/build/js/
            'js/app.js'
        ]);
});
