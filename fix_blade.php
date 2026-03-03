<?php
$viewsDir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getRealPath());
        $changed = false;
        
        if (strpos($content, '"@context"') !== false) {
            $content = str_replace('"@context"', '"@@context"', $content);
            $changed = true;
        }
        if (strpos($content, '"@type"') !== false) {
            $content = str_replace('"@type"', '"@@type"', $content);
            $changed = true;
        }
        
        if ($changed) {
            file_put_contents($file->getRealPath(), $content);
            echo "Fixed: " . $file->getRealPath() . PHP_EOL;
        }
    }
}
