<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = app('router')->getRoutes();
$found = false;
foreach ($routes as $route) {
    if ($route->getName() === 'ktm.download') {
        echo 'FOUND ' . implode(',', $route->methods()) . ' ' . $route->uri() . ' ' . $route->getName() . "\n";
        $found = true;
    }
}
if (! $found) {
    echo 'NOT_FOUND\n';
}
echo 'ROUTE_URL=' . route('ktm.download', [], false) . "\n";
