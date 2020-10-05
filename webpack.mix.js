const mix = require('laravel-mix');

  if (!mix.inProduction()) {
    let LiveReloadPlugin = require('webpack-livereload-plugin')
    let FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')
    mix.sourceMaps()
    mix.webpackConfig({
      devtool: 'source-map',
      plugins: [
        new FriendlyErrorsWebpackPlugin(),
        new LiveReloadPlugin()
      ],
      resolve: {
        alias: {
          '@': path.resolve(__dirname, 'resources/assets/'),
        }
      }
    })
    // mix.combine([
    //   'resources/assets/js/lib/client.js'
    // ])
  } else {
    mix.webpackConfig({
      resolve: {
        alias: {
          '@': path.resolve(__dirname, 'resources/assets/'),
        }
      }
    })
  }

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

  mix.setPublicPath('public')

  mix.js('resources/assets/js/app.js', 'dist/')
    .sass('resources/assets/sass/app.scss', 'dist/')
    .options({
      processCssUrls: false
    });
    
  if (mix.inProduction()) {
    mix.version()
  }


// mix.js('resources/assets/js/app.js', 'public/js')
//   .sass('resources/assets/sass/app.scss', 'public/css');