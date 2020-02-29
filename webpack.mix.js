const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const fs = require('fs');
const version = fs.readFileSync('./VERSION');

require('./mix-plugins/svgSprite');

mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.DefinePlugin({
                VERSION: JSON.stringify(version.toString()),
                ENV: JSON.stringify(process.env.NODE_ENV),
            })
        ]
    };
});

mix.setPublicPath('public/assets');

mix.svgSprite('resources/icons', 'admin/icons/sprite.svg');

mix.js('resources/js/legocms-admin.js', 'admin/js')
    .js('resources/js/legocms-auth.js', 'admin/js');

mix.sass('resources/sass/legocms-admin.scss', 'admin/css')
    .sass('resources/sass/legocms-auth.scss', 'admin/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    });



if(mix.inProduction()) {
    mix.copy('resources/vendor/jquery.min.js', 'public/assets/admin/js/jquery.js');
} else {
    mix.copy('resources/vendor/jquery.js', 'public/assets/admin/js/jquery.js');
}

mix.copyDirectory('resources/fonts', 'public/assets/admin/fonts');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.copyDirectory('public/assets', '/media/devs/projects/legocmsdemo/public/assets')
        .browserSync({
            proxy: {
                target: 'legocms.test',
                proxyReq: [
                    function(proxyReq) {
                        proxyReq.setHeader('X-Browsersync-Request', true);
                    }
                ]
            },
            snippetOptions: {
                rule: {
                    match: /<\/head>/i,
                    fn: function (snippet, match) {
                        return snippet + match;
                    }
                }
            },
        })
        .sourceMaps();
}
