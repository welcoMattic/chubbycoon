const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()

    .enableVersioning(Encore.isProduction())
    .enableSourceMaps(!Encore.isProduction())
    .enableBuildNotifications(!Encore.isProduction())

    .addEntry('js/admin', './assets/js/admin.js')
    .addEntry('js/app', './assets/js/app.js')
    .configureBabel(function(babelConfig) {
        babelConfig.presets.push('es2015');
    })

    .addStyleEntry('css/admin', './assets/css/admin.scss')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false,
    })

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
    })

    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
