<?php

return [
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'local'),
    'assets_path' => null,
    'cache_path' => base_path('bootstrap/cache/filament'),
    'should_register_core_routes' => true,
    'pages' => [
        'path' => base_path('app/Filament/Pages'),
        'namespace' => 'App\\Filament\\Pages',
    ],
    'resources' => [
        'path' => base_path('app/Filament/Resources'),
        'namespace' => 'App\\Filament\\Resources',
    ],
    'widgets' => [
        'path' => base_path('app/Filament/Widgets'),
        'namespace' => 'App\\Filament\\Widgets',
    ],
    'clusters' => [
        'path' => base_path('app/Filament/Clusters'),
        'namespace' => 'App\\Filament\\Clusters',
    ],
    'livewire' => [
        'namespace' => 'App\\Filament\\Livewire',
        'path' => base_path('app/Filament/Livewire'),
    ],
];
