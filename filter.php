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

    // checker for submitted task
    if(isset($_POST['task']) && $_POST['task'] != ""){
        // If the action variable has been set and is not empty (should never be)
        if($_POST['task'] == "changeURL"){
            // Changing the url variable
            $url = (isset($_POST['url']) && ($_POST['url'] != "#")) ? $_POST['url'] : "./placeholder.html";
            if(strpos($url, "https://") === FALSE){ // TODO: replace with regex expression
                // If url does not start with https://
                $url = "https://".$url;
            }
        }
    }

    if(isset($_REQUEST['source']) && $_REQUEST['source'] != "") {
        // If the source type for the iframes has been set, echo out iframes.
        createFrames($_REQUEST['source']);
    }

    /**
     * fillDropdowns - Function used to grab data from the json file specified
     *      in the given path, sorts the data by width, and echos data out as
     *      dropdown options.
     *
     * @param  [String] $filePath [path to json file in assets/data folder]
     * @return null
     */
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


    /**
     * createFrames - Creates test iframes based on display options.
     *      Displays iframes based on COMMON_WIDTHS array on initial window load
     *      or display by width is selected. Displays iframes based on device
     *      widths stored in json files otherwise.
     * @return null
     */
    function createFrames(){
        global $COMMON_WIDTHS, $url;

        foreach($COMMON_WIDTHS as $curr){
            // Place each iframe and it's width title
            // together in one div
            echo "<div class='frame-holder'>";
            echo "<span>".$curr."</span>";
            echo "<iframe src='".$url."' ";
            echo "width='".$curr."' height='500'>";
            echo "</iframe>";
            echo "</div>\n\t\t\t\t";
        }
    } // End of createFrames

?>
