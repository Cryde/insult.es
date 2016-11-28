module.exports = {
    files: {
        javascripts: {
            joinTo: {
                'app.js': /^(src|node_modules)/
            }
        },
        stylesheets: {
            joinTo: 'app.css'
        }
    },
    plugins: {
        babel: {
            presets: ['latest']
        },
        cleancss: {
            removeEmpty: true,
            keepSpecialComments: 0,
            restructure: true
        }
    },
    paths: {
        // Change the "public" path (where the build will go)
        "public": 'web/',
        // We change the "app" path
        'watched': ['src/AppBundle/Resources/public']
    },
    conventions: {
        // With this Brunch will copy all folder in this folder without touching them (img, font, ...)
        'assets': /^src\/AppBundle\/Resources\/public\/assets/
    },
    modules: {
        // This will allow us to require/import JS file without specify ALL the path
        nameCleaner: function (path) {
            return path.replace(/^src\/AppBundle\/Resources\/public\//, '');
        }
    }
};