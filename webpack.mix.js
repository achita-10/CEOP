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

mix.js('resources/js/app.js', 'public/js').
styles([
   'resources/plantilla/css/themify-icons/themify-icons.css',
   'resources/plantilla/css/index.css',
],'public/css/themify-icons.css').
scripts([
   /*Core JS Files */
   'resources/plantilla/js/carga.js',
   'resources/plantilla/js/vendor.js',
   'resources/plantilla/js/bundle.js',
],'public/js/all.js')
.sass('resources/sass/app.scss', 'public/css').
   copy('node_modules/element-ui/lib/theme-chalk/fonts/', 'public/fonts')
.styles([
      'resources/login/vendor/bootstrap/css/bootstrap.min.css',
      'resources/login/css/util.css',
      'resources/login/css/main.css',
  ],'public/css/login.css').
  scripts(['resources/login/vendor/jquery/jquery-3.2.1.min.js',
  'resources/login/vendor/animsition/js/animsition.min.js',
  'resources/login/vendor/bootstrap/js/popper.js',
  'resources/login/vendor/bootstrap/js/bootstrap.min.js',
  'resources/login/vendor/select2/select2.min.js',
  'resources/login/vendor/daterangepicker/moment.min.js',
  'resources/login/vendor/daterangepicker/daterangepicker.js',
  'resources/login/vendor/countdowntime/countdowntime.js',
  'resources/login/js/main.js',
  ], 'public/js/login.js');

   /*
      esta linea de codigo la elimine de archivo bootstrap.min.js 
      para poder permitir acceder a la propiedad de los modales
      y ejecutar el menu de cierre de sesion
   ,function(t){t.preventDefault(),t.stopPropagation(),e.toggle()} 
   
   */