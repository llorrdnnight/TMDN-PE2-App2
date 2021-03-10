<?php
    define("DB_HOST", "localhost");
    define("DB_USERNAME", "Test");
    define("DB_PASSWORD", "Test");
    define("DB_DATABASE", "Management");
    define("TBL_DELIVERIES", "Deliveries");
    define("TBL_COMPLAINTS", "Complaints");
    
    // function CustomErrorHandler($errno, $errMsg, $errFile, $errLine) 
    // {
    //     $error = '[' . $errno . '] ';
    //     $error .= '&lt' . $errMsg . '&gt';
    //     $error .= "<br>File: " . $errFile . " => Line " . $errLine;

    //     logError($errno, $errMsg, $errFile, $errLine);
    //     echo $error;

    //     exit();
    // }

    // function logError($errno, $errMsg, $errFile, $errLine) 
    // {
    //     $logfile = "./log.txt";

    //     $error = '[' . date("Y-m-d H:i:s") . '] ';
    //     $error .= '[' . $errno . '] ';
    //     $error .= '<' . $errMsg . '>';
    //     $error .= "File: " . $errFile . " => Line " . $errLine . "\n";

    //     // Log details of error in a file
    //     error_log($error, 3, $logfile);
    // }

    // function CustomExceptionHandler($e)
    // {
    //     logError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    //     exit("An unexpected error occurred. Please contact the system administrator!");
    // }

    // voor later
    // ini_set('log_errors', TRUE); // Error/Exception file logging engine.
    // ini_set('error_log', './log.txt'); // Logging file path

    // voor later
    // set_error_handler("CustomErrorHandler");
    // set_exception_handler('CustomExceptionHandler');
?>