<?php
$res = file_get_contents('http://127.0.0.1:8000/sitemap.xml');
echo urlencode(substr($res, 0, 50));
echo "\n=====\n";
echo substr($res, 0, 100);
