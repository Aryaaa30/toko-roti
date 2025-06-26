<?php
// Check if we're on port 8000
if ($_SERVER['SERVER_PORT'] == '8000') {
    // Get the current URL
    $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    // Replace port 8000 with 1114
    $newUrl = str_replace(':8000', ':1114', $currentUrl);
    
    // Redirect to the new URL
    header("Location: $newUrl");
    exit;
}