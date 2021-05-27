<?php
    //Use the PATHS definitions as a replacement for typing the full pathname of a file you need.
    //These paths are separated in 2 categories: those you use in PHP files and those for HTML, because HTML uses a different root path.
    //To add your own file or folder paths, follow the examples below. Make sure to add them under the right category eg. HTML paths under HTML header.
    //Also, make sure to end every folder path with a '/' so you dont have to prefix filenames with it.

    //L0
    define("ROOTDIR", realpath(dirname(__FILE__) . '/..')); //If this file were to be put next to the root folder, it would not be included in the Github repo.
    define("GITDIR", ROOTDIR . "/app2/");

    //L1 DIRECTORIES
    define("COMPONENTSDIR", GITDIR . "components/");
    define("CSSDIR", GITDIR . "css/");
    define("MOCKDIR", GITDIR . "database/"); //                                     <= remove when not needed anymore, so after main database is fully in use.
    define("HRDIR", GITDIR . "HR/");
    define("IMAGESDIR", GITDIR . "images/");
    define("INCLUDESDIR", GITDIR . "includes/");
    define("LOGDIR", GITDIR . "logs/");
    define("MANAGEMENTDIR", GITDIR . "management/");
    define("SCRIPTSDIR", GITDIR . "scripts/");

    //L2 DIRECTORIES
    define("LEAVEDIR", HRDIR . "leave/");
    define("COMPLAINTSDIR", MANAGEMENTDIR . "complaints/");

    define("JAVASCRIPTDIR", SCRIPTSDIR . "javascript/");
    define("PHPSCRIPTDIR", SCRIPTSDIR . "php/");
    define("PHPCLASSDIR", PHPSCRIPTDIR . "classes/");

    //HTML
    define("HTMLROOT", '/' . basename(GITDIR) . '/'); //This is currently the TMDN-PE2-App2 directory, which is not the same as the PHP root directory

    define("HTMLHR", HTMLROOT . "HR/");
    define("HTMLMANAGEMENT", HTMLROOT . "management/");
    define("HTMLCSS", HTMLROOT . "css/");
    define("HTMLIMAGES", HTMLROOT . "images/");
    define("HTMLSCRIPTS", HTMLROOT . "scripts/");

    define("HTMLLEAVE", HTMLHR . "leave/");
    define("HTMLCOMPLAINTS", HTMLMANAGEMENT . "complaints/");

    define("HTMLJAVASCRIPT", HTMLSCRIPTS . "javascript/");
    define("HTMLPHP", HTMLSCRIPTS . "php/");

    //----------------------------------------------------------------

    //FILENAMES
    define("COMPONENT_HRHEAD", "head/hrhead.php");
    define("COMPONENT_MANAGEMENTHEAD", "head/managementhead.php");

    define("COMPONENT_HR_BODY_TOP", "body/hr_body_top.php");
    define("COMPONENT_MANAGEMENT_BODY_TOP", "body/management_body_top.php");
    define("COMPONENT_BODY_BOTTOM", "body/body_bottom.php");
    define("COMPONENT_FOOTER", "body/footer.php");

    define("COMPONENT_HR_NAV", "navigation/hr_nav.php");
    define("COMPONENT_MANAGEMENT_NAV", "navigation/management_nav.php");
    define("COMPONENT_LEAVENAV", "navigation/leavenav.php");
    define("COMPONENT_COMPLAINTSNAV", "navigation/complaintsnav.html");

    define("CSS_RESET", "reset.css");
    define("CSS_PROFILE", "style.css");
    define("CSS_COMMON", "common.css");
    define("CSS_BOOTSTRAP", "bootstrap.css");
    define("CSS_HRSTYLE", "hrstyle.css");
    define("CSS_MANAGEMENTSTYLE", "managementstyle.css");

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
