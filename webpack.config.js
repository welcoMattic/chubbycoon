var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabel(function(babelConfig) {
        // add additional presets
        babelConfig.presets.push('es2015-without-strict');
        babelConfig.presets.push('stage-1');

        // no plugins are added by default, but you can add some
        // babelConfig.plugins = ['styled-jsx/babel'];
    })

    .addEntry('js/admin', './assets/js/admin.js')
    .addStyleEntry('css/admin', './assets/css/admin.scss')

    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
