<?php

use Illuminate\Support\Facades\Artisan;

use function Laravel\Prompts\select;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('project:prepare', function () {
    $this->comment('Preparing project');
    $environment = select(
        label: 'What environment are you in?',
        options: [
            'dev' => 'Development',
            'prod' => 'Production',
        ]
    );

    $steps = [
        'dev' => [
            'project:clear  --no-interaction',
            'migrate:reset  --no-interaction',
            'db:seed --no-interaction',
            'key:generate --no-interaction',
        ],
        'prod' => [
            'project:clear --no-interaction',
            'migrate --no-interaction',
            'project:cache --no-interaction',
        ],
    ];

    $this->withProgressBar($steps[$environment], function ($step) {
        Artisan::call($step);
    });

    $this->info(PHP_EOL.' Project ready');
});

Artisan::command('project:clear', function () {
    $this->comment('Clearing project cache');
    $this->info("Clearing the cache may affect the application's performance");
    if ($this->confirm('Do you want to continue?', true)) {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('event:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        $this->info('Project successfully cleaned');
    }
});

Artisan::command('project:cache', function () {
    $this->comment('Creating project cache');
    Artisan::call('view:cache');
    Artisan::call('event:cache');
    Artisan::call('config:cache');
    Artisan::call('route:cache');

    $this->info('Cache created successfully');
});
