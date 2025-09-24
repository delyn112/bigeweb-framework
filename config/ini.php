<?php
/**
 * Testing PHP cookie settings and improve security.
 */
use illuminate\Support\Facades\Config;
ini_set('memory_limit', '40000M'); // Set memory limit to 256MB
ini_set('max_file_uploads', '20');            // Set maximum number of file uploads to 20
ini_set('upload_max_filesize', '40000M'); // Set maximum upload file size to 800MB
ini_set('post_max_size', '40000M');  // Set max post size to 800MB
ini_set('max_execution_time', '40000M'); // Set max execution time to 2000 seconds
ini_set('allow_url_fopen', '1');               // Allow URL fopen
ini_set('date.timezone', Config::get('app.timezone')); // Set timezone
ini_set('display_errors', Config::get('app.debug'));   // Enable error display (set to "0" in production)