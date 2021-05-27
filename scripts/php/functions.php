<?php
    function in_array_recursive($needle, $haystack) //We look for the correct id in the array. It is possible an id does not exist. In that case, we exit.
    {
        $index = 0;

        foreach($haystack as $item)
        {
            if ($item["id"] == $needle)
                return $index;
            $index++;
        }

        exit("<h3>The requested index complaint index does not exist.</h3>");
    }
?>