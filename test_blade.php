<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
echo Illuminate\Support\Facades\Blade::compileString(file_get_contents('resources/views/layouts/main.blade.php'));
