<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

echo "=== CHECKING CATEGORIES ===" . PHP_EOL;
$categories = Category::all(['id', 'name', 'image']);

foreach ($categories as $category) {
    echo "ID: {$category->id}" . PHP_EOL;
    echo "Name: {$category->name}" . PHP_EOL;
    echo "Image: " . ($category->image ?: 'NULL') . PHP_EOL;
    
    if ($category->image) {
        $fullPath = public_path($category->image);
        echo "Full Path: {$fullPath}" . PHP_EOL;
        echo "File Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . PHP_EOL;
        
        if (file_exists($fullPath)) {
            echo "Asset URL: " . asset($category->image) . PHP_EOL;
            echo "Direct URL: /" . $category->image . PHP_EOL;
        }
    }
    echo "---" . PHP_EOL;
}

echo "=== CHECKING UPLOADS DIRECTORY ===" . PHP_EOL;
$uploadDir = public_path('uploads/categories');
echo "Upload Dir: {$uploadDir}" . PHP_EOL;
echo "Dir Exists: " . (is_dir($uploadDir) ? 'YES' : 'NO') . PHP_EOL;
echo "Dir Writable: " . (is_writable($uploadDir) ? 'YES' : 'NO') . PHP_EOL;

if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    echo "Files in uploads/categories:" . PHP_EOL;
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- {$file}" . PHP_EOL;
        }
    }
}
