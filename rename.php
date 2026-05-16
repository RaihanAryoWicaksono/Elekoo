<?php

$paths = [
    __DIR__ . '/resources/views',
    __DIR__ . '/database/seeders/DatabaseSeeder.php',
    __DIR__ . '/.env',
];

function processDirectory($path) {
    if (is_file($path)) {
        replaceInFile($path);
    } elseif (is_dir($path)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                replaceInFile($file->getPathname());
            }
        }
    }
}

function replaceInFile($filePath) {
    $content = file_get_contents($filePath);
    
    // We want to replace "TechNova" with "Elekoo" and "technova" with "elekoo"
    // except for DB_DATABASE in .env
    $newContent = str_replace('TechNova', 'Elekoo', $content);
    
    // Replace technova with elekoo but avoid DB_DATABASE=technova
    // So let's replace "technova.id" -> "elekoo.id"
    // "technova" -> "elekoo" inside strings, maybe just case sensitive replacement
    $newContent = str_replace('technova.id', 'elekoo.id', $newContent);
    $newContent = str_replace('admin@technova', 'admin@elekoo', $newContent);
    
    // If it's .env file, replace APP_NAME
    if (basename($filePath) === '.env') {
        $newContent = preg_replace('/APP_NAME\s*=\s*.*/', 'APP_NAME="Elekoo"', $newContent);
    }

    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
    }
}

foreach ($paths as $path) {
    processDirectory($path);
}

echo "Done.\n";
