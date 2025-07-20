<?php

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

// Initialize $url
$url = '';

if (isset($_SERVER['HTTP_HOST'])) {
    // Check if HTTPS is enabled
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = $_SERVER['SCRIPT_NAME'];
    
    // Calculate base path by removing script name and ensuring trailing slash
    $basePath = rtrim(dirname($scriptName), '/\\') . '/'; // Ensures trailing slash
    
    // Construct base URL
    $url = $protocol . $host . $basePath;
    
    // Define BASEURL if not already defined
    if (!defined('BASEURL')) {
        define('BASEURL', $url);
    }
} else {
    // Fallback URL in case HTTP_HOST is not set
    $url = 'http://localhost/';
    
    // Define BASEURL if not already defined
    if (!defined('BASEURL')) {
        define('BASEURL', $url);
    }
}

// Optional Debugging Output
// echo 'Constructed BASEURL: ' . BASEURL;
// exit; // Stop execution to inspect the output

$minPhpVersion = '8.1'; // Minimum required PHP version
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '/app/Config/Paths.php'; // Adjust if the application folder is moved

$paths = new Config\Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));

