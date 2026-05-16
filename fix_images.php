<?php
$directory = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $newContent = preg_replace(
            '/Storage::url\(\$([a-zA-Z0-9_\-\>]+(?:image|logo|photo|avatar))\)/',
            '\Illuminate\Support\Str::startsWith($\1, [\'http://\', \'https://\']) ? $\1 : Storage::url($\1)',
            $content
        );

        if ($newContent !== $content) {
            file_put_contents($path, $newContent);
            echo "Updated: " . $path . "\n";
        }
    }
}
echo "Done.\n";
