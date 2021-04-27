<?php
    //PATHS
    define("ROOTDIR", realpath(dirname(__FILE__) . '/..'));
    define("GITDIR", ROOTDIR . "/TMDN-PE2-App2/");
    define("MANAGEMENTDIR", GITDIR . "Management/");

    define("INCLUDESDIR", MANAGEMENTDIR . "includes/");
    define("COMPONENTSDIR", MANAGEMENTDIR . "components/");
    define("COMPLAINTSDIR", MANAGEMENTDIR . "complaints/");

    define("SCRIPTSDIR", MANAGEMENTDIR . "scripts/");
    define("JAVASCRIPTDIR", SCRIPTSDIR . "javascript/");
    define("PHPSCRIPTDIR", SCRIPTSDIR . "php/");

    define("CSSDIR", MANAGEMENTDIR . "css/");

    //HTML
    define("HTMLROOT", '/' . basename(GITDIR) . '/');
    define("HTMLMANAGEMENT", HTMLROOT . "Management/");
    define("HTMLCOMPLAINTS", HTMLMANAGEMENT . "complaints/");

    define("HTMLSCRIPTS", HTMLMANAGEMENT . "scripts/");
    define("HTMLJAVASCRIPT", HTMLSCRIPTS . "javascript/");
    define("HTMLPHP", HTMLSCRIPTS . "php/");

    define("HTMLCSS", HTMLMANAGEMENT . "css/");
    define("HTMLIMAGES", HTMLROOT . "images/");

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
    //HTML does not go well with absolute paths, so we could make it relative to the page.
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