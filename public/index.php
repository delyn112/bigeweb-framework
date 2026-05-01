<?php

use illuminate\Support\Loader;

header("Access-Control-Allow-Origin: *"); // Adjust to your React app's URL
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow necessary methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

require(__DIR__.'/../vendor/autoload.php');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
//Let the application begins to load
new Loader()

?>
