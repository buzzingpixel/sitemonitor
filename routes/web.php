<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Get includes
 */

// Get recursive directory iterator class
$directory = new RecursiveDirectoryIterator(__DIR__ . '/includes');

// Get the iterator
$iterator = new RecursiveIteratorIterator($directory);

// Get the regex iterator
$regexIterator = new RegexIterator(
    $iterator,
    '/^.+\.php$/i',
    RecursiveRegexIterator::GET_MATCH
);

// Iterate through the php files
foreach ($regexIterator as $item) {
    // Iterate the array
    foreach ($item as $file) {
        // Include the file
        include $file;
    }
}
