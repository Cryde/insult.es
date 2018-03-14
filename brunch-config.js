module.exports = {
  files: {
    javascripts: {
      joinTo: {
        'app.js': /^(assets|node_modules)/
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
    },
    eslint: {
      pattern: /^assets\/.*\.js?$/,
      warnOnly: true,
      config: {rules: {'array-callback-return': 'warn'}}
    },
    fingerprint: {
      manifest: './public/manifest.json',
      destBasePath: 'public/',
      srcBasePath: 'public/',
      autoClearOldFiles: true,
      autoReplaceAndHash: true,
      ///publicRootPath: 'web/',
      hashLength: 15,
      verbose: true
    }
  },
  paths: {
    // Change the "public" path (where the build will go)
    //"public": 'public/',
    // We change the "app" path
    'watched': ['assets']
  },
  conventions: {
    // With this Brunch will copy all folder in this folder without touching them (img, font, ...)
    'assets': /^assets\/assets/
  },
  modules: {
    autoRequire: {
      'app.js': ['app']
    },
    // This will allow us to require/import JS file without specify ALL the path
    nameCleaner: function (path) {
      return path.replace(/^assets\//, '');
    }
  }
};