var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel(function(babelConfig) {
        // add additional presets
        babelConfig.presets.push('es2015-without-strict');
        babelConfig.presets.push('stage-1');

        // no plugins are added by default, but you can add some
        // babelConfig.plugins = ['styled-jsx/babel'];
    })

    // uncomment to define the assets of the project
    .addEntry('js/admin', './assets/js/admin.js')
    .addStyleEntry('css/admin', './assets/css/admin.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
