<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
try {
    $response = $kernel->handle($request);
    if (isset($response->exception)) {
        throw $response->exception;
    }
} catch (\Throwable $e) {
    file_put_contents('err.txt', $e->getMessage() . PHP_EOL . $e->getFile() . ':' . $e->getLine());
    echo "Wrote error to err.txt";
}
