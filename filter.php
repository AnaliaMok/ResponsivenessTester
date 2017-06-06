<?php
    /**
    * File Name: filter.php
    * Description: File containing encapsulated functions that will be used
    *      index.php and other logic to help with the rest of this "application's"
    *      functionality
    *
    * @author Analia Mok
    */

    // Constant array for storing set screen widths
    $COMMON_WIDTHS = array(240, 320, 768, 1024, 1366, 1440);

    // URL used by the iframes - by default, just current page
    $url = "./placeholder.html";

    function fillDropdowns($filePath){
        $fileContents = file_get_contents($filePath);
        // Multidimensional array
        $data = json_decode($fileContents, true);
        usort($data, function($first, $second){
            return (int)$first['width'] > (int)$second['width'];
        });

        $totalItems = count($data);
        for($i = 0; $i < $totalItems; $i++){
            $currItem = $data[$i];
            echo "<option>";
            echo $currItem["device"]." (".$currItem["width"]."x".$currItem["height"].")";
            echo "</option>\n\t\t\t\t\t\t\t";
        }
    } // End of fillDropdowns


    if(isset($_POST['task']) && $_POST['task'] != ""){
        // If the action variable has been set and is not empty (should never be)
        if($_POST['task'] == "changeURL"){
            // Changing the url variable
            $url = (isset($_POST['url']) && ($_POST['url'] != "#")) ? $_POST['url'] : "./placeholder.html";
            if(strpos($url, "https://") === FALSE){
                $url = "https://".$url;
            }
        }
    }

?>
