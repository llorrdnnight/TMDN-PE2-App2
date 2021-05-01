<?php 
// Defines the path of the root directory - use this to build paths to images and other files (anchor tags)
// Makes it so if we include a re-usable component (like a footer or navigation bar) in another php file the paths match no matter how deep a file is situated (directory-wise)
define('ROOT_PATH', realpath(dirname(__FILE__)));
?>