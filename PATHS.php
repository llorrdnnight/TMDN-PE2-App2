<?php
    //Use the PATHS definitions as a replacement for typing the full pathname of a file you need.
    //These paths are separated in 2 categories: those you use in PHP files and those for HTML, because HTML uses a different root path.
    //To add your own file or folder paths, follow the examples below. Make sure to add them under the right category eg. HTML paths under HTML header.
    //Also, make sure to end every folder path with a '/' so you dont have to prefix filenames with it.

    //L1 DIRECTORIES
    define("ROOTDIR", realpath(dirname(__FILE__) . '/..')); //If this file were to be put next to the root folder, it would not be included in the Github repo.
    define("GITDIR", ROOTDIR . "/TMDN-PE2-App2/");
    define("MANAGEMENTDIR", GITDIR . "Management/");
    define("LOGDIR", GITDIR . "Logs/");

    //L2 DIRECTORIES
    define("INCLUDESDIR", MANAGEMENTDIR . "includes/");
    define("COMPONENTSDIR", MANAGEMENTDIR . "components/");
    define("COMPLAINTSDIR", MANAGEMENTDIR . "complaints/");
    define("SCRIPTSDIR", MANAGEMENTDIR . "scripts/");
    define("CSSDIR", MANAGEMENTDIR . "css/");

    //L3 DIRECTORIES
    define("JAVASCRIPTDIR", SCRIPTSDIR . "javascript/");
    define("PHPSCRIPTDIR", SCRIPTSDIR . "php/");

    //HTML
    define("HTMLROOT", '/' . basename(GITDIR) . '/');
    define("HTMLMANAGEMENT", HTMLROOT . "Management/");

    define("HTMLCOMPLAINTS", HTMLMANAGEMENT . "complaints/");
    define("HTMLSCRIPTS", HTMLMANAGEMENT . "scripts/");
    define("HTMLCSS", HTMLMANAGEMENT . "css/");
    define("HTMLIMAGES", HTMLROOT . "images/");
    
    define("HTMLJAVASCRIPT", HTMLSCRIPTS . "javascript/");
    define("HTMLPHP", HTMLSCRIPTS . "php/");

    //----------------------------------------------------------------

    //FILENAMES
    define("COMPONENT_HEAD", "head.php");
    define("COMPONENT_BODY_TOP", "body_top.php");
    define("COMPONENT_BODY_BOTTOM", "body_bottom.php");
    define("COMPONENT_NAV", "nav.php");
    define("COMPONENT_COMPLAINTSNAV", "complaintsnav.html");
    define("COMPONENT_FOOTER", "footer.php");

    define("CSS_RESET", "reset.css");
    define("CSS_STYLE", "style.css");

    //NOT USED ANYMORE, HTML VARIABLES RELATIVE TO ROOT PATH ARE A SIMPLER OPTION
    //https://stackoverflow.com/questions/2637945/getting-relative-path-from-absolute-path-in-php
    //HTML does not go well with absolute paths (with spaces), so we could make it relative to the page.
    function getRelativePath($from, $to)
    {
        // some compatibility fixes for Windows paths
        $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
        $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
        $from = str_replace('\\', '/', $from);
        $to   = str_replace('\\', '/', $to);

        $from     = explode('/', $from);
        $to       = explode('/', $to);
        $relPath  = $to;

        foreach($from as $depth => $dir) 
        {
            // find first non-matching dir
            if($dir === $to[$depth]) 
            {
                // ignore this directory
                array_shift($relPath);
            } 
            else 
            {
                // get number of remaining dirs to $from
                $remaining = count($from) - $depth;
                if($remaining > 1) 
                {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } 
                else 
                {
                    $relPath[0] = './' . $relPath[0];
                }
            }
        }

        return implode('/', $relPath);
    }
?>