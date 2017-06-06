<?php

    if(isset($_POST['task']) && $_POST['task'] != ""){
        // If the action variable has been set and is not empty (should never be)
        if($_POST['task'] == "changeURL"){
            // Changing the url variable
            $url = (isset($_POST['url']) && ($_POST['url'] != "#")) ? $_POST['url'] : "https://www.w3schools.com/";
            if(strpos($url, "https://") === FALSE){
                $url = "https://".$url;
            }
        }
    }else{
        // Default value for url used in iframes
        $url = "#";
    }

?>
