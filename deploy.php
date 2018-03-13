<?php

namespace Deployer;

require 'recipe/symfony4.php';
require 'vendor/deployer/recipes/recipe/npm.php';

// Project repository
set('repository', 'git@github.com:Cryde/insult.es.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('keep_releases', 2);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', ['var/sessions']);

// Writable dirs by web server 
add('writable_dirs', []);

// Hosts
inventory('hosts.yml');

set(
    'env',
    function () {
        return [
            'APP_ENV'      => get('APP_ENV'),
            'DATABASE_URL' => get('DATABASE_URL'),
        ];
    }
);

// Tasks
desc('Build Brunch assets');
task(
    'assets:build',
    function () {
        run('cd {{release_path}} && {{bin/npm}} run build');
    }
);
after('npm:install', 'assets:build');

desc('Remove node_modules folder');
task(
    'assets:clean',
    function () {
        run('cd {{release_path}} && rm -rf node_modules');
    }
);
after('deploy:symlink', 'assets:clean');

desc('Restart PHP-FPM service');
task(
    'php-fpm:restart',
    function () {
        run('sudo service php7.2-fpm reload');
    }
);
after('cleanup', 'php-fpm:restart');


task(
    'deploy:cache:clear',
    function () {
        run('{{bin/php}} {{bin/console}} cache:clear --no-warmup');
    }
)->desc('Clear cache');

task(
    'deploy:cache:warmup',
    function () {
        run('{{bin/php}} {{bin/console}} cache:warmup');
    }
)->desc('Warm up cache');
before('deploy:symlink', 'deploy:cache:clear');

after('deploy:cache:clear', 'deploy:cache:warmup');


// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');
after('deploy:update_code', 'npm:install');
