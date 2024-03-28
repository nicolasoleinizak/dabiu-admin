<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$envFilePath = __DIR__ . '/.env';

try {
    $envContents = file_get_contents($envFilePath);
    $envLines = explode("\n", $envContents);
    
    foreach ($envLines as $line) {
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
    
        list($key, $value) = explode('=', $line, 2);
    
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
    
        putenv("$key=$value");
    }
    
    $_ENV = $_SERVER = array_merge($_ENV, $_SERVER);
} catch (Exception $e) {
    
}

$BASE_PATH = getenv('API_BASE_PATH') | '/..';


if (file_exists($maintenance = __DIR__.$BASE_PATH.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.$BASE_PATH.'/vendor/autoload.php';

$app = require_once __DIR__.$BASE_PATH.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
