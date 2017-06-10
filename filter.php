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
    //$url = "./placeholder.html";

    // checker for submitted task
    if(isset($_POST['task']) && $_POST['task'] != ""){
        // If the action variable has been set and is not empty (should never be)
        switch ($_POST['task']) {
            case 'changeURL':
                // Changing the url variable
                $url = (isset($_POST['url']) && ($_POST['url'] != "#")) ? $_POST['url'] : "./placeholder.html";

                if(strpos($url, "https://") === FALSE){ // TODO: replace with regex expression
                    // If url does not start with https://
                    $url = "https://".$url;
                }

                break;
            case "addDevice":
                echo "<p>Add Device Request found ".$_POST['deviceName']."</p>";
                // TODO: Create function to adjust frameData array and output
                // htmk content
                break;
            case "removeDevice":
                echo "<p>Remove Device Request found ".$_POST['deviceName']."</p>";
                // TODO: Create function to adjust frameData array and output
                // htmk content
                break;
            default:
                // TODO
                break;
        }

    }

    if(isset($_REQUEST['source']) && $_REQUEST['source'] != "") {
        // If the source type for the iframes has been set, echo out iframes.
        createFrames($_REQUEST['source'], $_REQUEST['url']);
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
            // Add style class based on selected field
            if($currItem['selected'] === "true"){
                echo '<option class="selected">';
            }else{
                echo "<option>";
            }
            echo $currItem["device"]." (".$currItem["width"]."x".$currItem["height"].")";
            echo "</option>\n\t\t\t\t\t\t\t";
        }
    } // End of fillDropdowns


    /**
     * createFrames - Creates test iframes based on display options.
     *      Displays iframes based on COMMON_WIDTHS array on initial window load
     *      or display by width is selected. Displays iframes based on device
     *      widths stored in json files otherwise.
     * @param source String indicating what type of iframes to echo
     * @return null
     */
    function createFrames($source, $url){
        global $COMMON_WIDTHS, $frameData;
        //$url = $GLOBALS['url'];

        if($source == "width"){
            $frameData = $COMMON_WIDTHS;
        }else{
            // Restart with a new array
            $frameData = array();
            // Apple Devices
            $fileContents = file_get_contents("assets/data/apple_devices.json");
            $appleData = json_decode($fileContents, true);

            // Android devices
            $fileContents = file_get_contents("assets/data/android_devices.json");
            $androidData = json_decode($fileContents, true);

            // All Devices - Only display one's with a true "selected" value
            $data = array_merge($appleData, $androidData);

            foreach ($data as $curr) {
                if($curr['selected'] === "true"){
                    $newKey = $curr['device'];
                    $frameData[(string)$newKey] = $curr;
                }
            }

            // Sort by increasing width
            uasort($frameData, function($first, $second){
                return (int)$first['width'] > (int)$second['width'];
            });

        }

        foreach($frameData as $curr){
            // Place each iframe and it's width title together in one div
            echo "<div class='frame-holder'>";

            // For display by width, just use curr var; otherwise, insert device
            // name and its dimensions
            $output = ($source == "width") ? $curr : ($curr['device']." (".$curr["width"]."x".$curr["height"].")");
            echo "<span>".$output."</span>";
            echo "<iframe src='".$url."' ";

            // For display by width, just use curr var; otherwise, need to
            // dereference multidim array
            $width = ($source == "width") ? $curr : $curr['width'];
            echo "width='".$width."' height='500'>";
            echo "</iframe>";
            echo "</div>\n\t\t\t\t";
        }

    } // End of createFrames

?>
