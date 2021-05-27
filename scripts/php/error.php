<?php
    define("ERROR_FILE", "error.log");
    define("SHOW_ERRORS", 1); //move to config file
    
    ini_set('log_errors', true); // Error/Exception file logging engine.
    ini_set("error_log", LOGDIR . ERROR_FILE); // Logging file path

    set_error_handler("customErrorHandler");
    set_exception_handler("customExceptionHandler");

    function customErrorHandler($number, $message, $file = null, $line = null, $context = null)
    {
        if (SHOW_ERRORS)
        {
            $error = "<h1>Application Error</h1><br>";
            $error .= "The application could not run because of the following error: <br>";
            $error .= "<table><tbody>";
            $error .= "<tr><td><b>Type</b></td><td>Error</td></tr>";
            $error .= "<tr><td><b>Code</b></td><td>" . $number . "</td></tr>";
            $error .= "<tr><td><b>Message</b></td><td>" . $message . "</td></tr>";
            
            if ($file)
                $error .= "<tr><td><b>File</b></td><td>" . $file . "</td></tr>";

            if ($line)
                $error .= "<tr><td><b>Line</b></td><td>" . $line . "</td></tr>";

            echo $error;
        }
        else
        {
            $error = "Something went wrong, please try again later.";
        }

        logError($number, $message, $file, $line, $context) ;
        exit;
    }

    function logError($number, $message, $file, $line, $context) 
    {
        $error = "";
        $error .= '[' . date("Y-m-d H:i:s") . '] ' . "'Europe/Brussels'" . "\n";
        $error .= '[' . $number . '] ';
        $error .= '<'. $message . '>';
        $error .= "\nFile: " . $file . " on line " . $line . "\n\n";

        error_log($error, 3, LOGDIR . ERROR_FILE);
    }

    function customExceptionHandler($exception) 
    {
        echo "Uncaught exception: " , $exception->getMessage(), "\n";
    }
?>