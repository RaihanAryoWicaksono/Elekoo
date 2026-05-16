<?php

$paths = [
    __DIR__ . '/app/Http/Controllers/Auth',
    __DIR__ . '/tests/Feature/Auth',
    __DIR__ . '/resources/views/layouts/navigation.blade.php'
];

foreach ($paths as $path) {
    if (is_file($path)) {
        processFile($path);
    } elseif (is_dir($path)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                processFile($file->getPathname());
            }
        }
    }
}

function processFile($filePath) {
    $content = file_get_contents($filePath);
    $newContent = str_replace("route('dashboard'", "route('home'", $content);
    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
    }
}
echo "Done.\n";
