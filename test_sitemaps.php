<?php
// Test Sitemaps
$urls = [
    'http://127.0.0.1:8000/sitemap.xml',
    'http://127.0.0.1:8000/sitemaps/pages.xml',
    'http://127.0.0.1:8000/sitemaps/services.xml',
    'http://127.0.0.1:8000/sitemaps/districts.xml',
    'http://127.0.0.1:8000/sitemaps/programmatic.xml',
    'http://127.0.0.1:8000/sitemaps/blog.xml'
];
foreach ($urls as $url) {
    echo "Fetching: " . $url . "\n";
    try {
        $content = file_get_contents($url);
        echo "Size: " . strlen($content) . " bytes\n";
        echo "First 50 chars: " . substr($content, 0, 50) . "\n\n";
    } catch (Exception $e) {
        echo "Failed: " . $e->getMessage() . "\n\n";
    }
}
