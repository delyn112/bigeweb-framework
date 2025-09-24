<?php

function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
       mkdir($destination, 0755, true);
    }
    $files = scandir($source);
    foreach ($files as $file) {
       if ($file !== '.' && $file !== '..') {
          $sourceFile = $source . '/' . $file;
          $destinationFile = $destination . '/' . $file;
          if (is_dir($sourceFile)) {
             copyDirectory($sourceFile, $destinationFile);
          } else {
             copy($sourceFile, $destinationFile);
          }
       }
    }
 }

?>