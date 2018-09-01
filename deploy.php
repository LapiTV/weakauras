<?php

namespace Deployer;

require 'recipe/symfony.php';
require 'recipe/symfony4.php';

// Project name
set('application', 'lapi-weakauras');

// Project repository
set('repository', 'git@github.com:WFrancois/lapi-weakauras.git');
set('web_dir', 'public');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('symfony_env', 'PROD');

set('env', function() {
    return [
        'APP_ENV' => get('symfony_env'),
    ];
});


// Hosts
host('lapitv')
    ->set('deploy_path', '/home/projects/{{application}}');

// Tasks

task('deploy:assets:install', function () {
    run('{{bin/php}} {{bin/console}} assets:install {{console_options}} {{release_path}}/{{web_dir}}');
})->desc('Install bundle assets');

task('deploy:assets:webpack', function() {
    run('cd {{release_path}}; npm install');
    run('cd {{release_path}}; ./node_modules/.bin/encore production');
});

after('deploy:vendors', 'deploy:assets:install');
after('deploy:assets:install', 'deploy:assets:webpack');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');