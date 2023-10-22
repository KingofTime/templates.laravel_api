<?php

declare(strict_types=1);

$ignoreErrors = [];
$ignoreErrors[] = [
    'message' => '#^Call to an undefined method Illuminate\\\\Database\\\\Eloquent\\\\Builder\\<Illuminate\\\\Database\\\\Eloquent\\\\Model\\>\\|Illuminate\\\\Database\\\\Eloquent\\\\Model\\:\\:onlyTrashed\\(\\)\\.$#',
    'count' => 2,
    'path' => __DIR__.'/app/Repositories/UserRepository.php',
];
$ignoreErrors[] = [
    'message' => '#^Access to an undefined property Illuminate\\\\Database\\\\Eloquent\\\\Model\\:\\:\\$id\\.$#',
    'count' => 2,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];
$ignoreErrors[] = [
    'message' => '#^Access to an undefined property Illuminate\\\\Database\\\\Eloquent\\\\Model\\:\\:\\$name\\.$#',
    'count' => 3,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];
$ignoreErrors[] = [
    'message' => '#^Cannot access property \\$id on App\\\\Models\\\\User\\|null\\.$#',
    'count' => 2,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];
$ignoreErrors[] = [
    'message' => '#^Cannot access property \\$id on Illuminate\\\\Database\\\\Eloquent\\\\Model\\|null\\.$#',
    'count' => 8,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];
$ignoreErrors[] = [
    'message' => '#^Cannot access property \\$name on Illuminate\\\\Database\\\\Eloquent\\\\Model\\|null\\.$#',
    'count' => 8,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];
$ignoreErrors[] = [
    'message' => '#^Cannot call method delete\\(\\) on App\\\\Models\\\\User\\|null\\.$#',
    'count' => 4,
    'path' => __DIR__.'/tests/Unit/Repositories/GenericRepositoryTest.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
