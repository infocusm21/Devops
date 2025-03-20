<?php
header('Content-Type: application/json');

$searchQuery = isset($_GET['q']) ? strtolower($_GET['q']) : '';
$directory = '.'; // Root directory of your hosted files
$files = [];

function scanDirRecursive($dir, &$files, $searchQuery) {
    foreach (scandir($dir) as $file) {
        if ($file !== "." && $file !== "..") {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                scanDirRecursive($filePath, $files, $searchQuery);
            } else {
                if ($searchQuery === '' || strpos(strtolower($file), $searchQuery) !== false) {
                    $files[] = str_replace('./', '', $filePath); // Remove leading `./`
                }
            }
        }
    }
}

scanDirRecursive($directory, $files, $searchQuery);
echo json_encode($files);
?>
