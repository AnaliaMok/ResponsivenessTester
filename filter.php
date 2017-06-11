<?php
    /**
    * File Name: filter.php
    * Description: File containing encapsulated functions that will be used
    *      index.php and other logic to help with the rest of this "application's"
    *      functionality
    *
    * @author Analia Mok
    */

    if(!isset($_SESSION)){
        // Start session if not already done
        // NEED to use session variable
        session_start();
    }

    // Constant array for storing set screen widths
    $COMMON_WIDTHS = array(240, 320, 768, 1024, 1366, 1440);

    // URL used by the iframes - by default, just current page
    //$url = "./placeholder.html";

    // checker for submitted task
    if(isset($_POST['task']) && $_POST['task'] != ""){
        // If the action variable has been set and is not empty (should never be)
        switch ($_POST['task']) {
            case "initialize":
                createNewFrames("width", $_POST['url']);
                break;
            case "changeURL":
                // Changing the url variable
                $_SESSION['url'] = (isset($_POST['url']) && ($_POST['url'] != "#")) ? $_POST['url'] : "./placeholder.html";

                if(strpos($_SESSION['url'], "https://") === FALSE){ // TODO: replace with regex expression
                    // If url does not start with https://
                    $_SESSION['url'] = "https://".$_SESSION['url'];
                }

                break;
            case "addDevice":
                addToFrameData($_POST['deviceName']);
                break;
            case "removeDevice":
                removeFromFrameData($_POST['deviceName']);
                break;
            default:
                // TODO
                break;
        }

    }

    if(isset($_REQUEST['source']) && $_REQUEST['source'] != "") {
        // If the source type for the iframes has been set, echo out iframes.
        createNewFrames($_REQUEST['source'], $_REQUEST['url']);
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
     * createNewFrames - Creates test iframes based on display options.
     *      Displays iframes based on COMMON_WIDTHS array on initial window load
     *      or display by width is selected. Displays iframes based on device
     *      widths stored in json files otherwise.
     * @param source String indicating what type of iframes to echo
     * @return null
     */
    function createNewFrames($source, $url){
        global $COMMON_WIDTHS;

        if($source == "width"){
            $_SESSION['frameData'] = $COMMON_WIDTHS;
        }else{
            // Restart with a new array
            $_SESSION['frameData'] = array();
            // Apple Devices
            $fileContents = file_get_contents("assets/data/apple_devices.json");
            $appleData = json_decode($fileContents, true);

            // Android devices
            $fileContents = file_get_contents("assets/data/android_devices.json");
            $androidData = json_decode($fileContents, true);

            // All Devices - Only display one's with a true "selected" value
            $data = array_merge($appleData, $androidData);

            foreach ($data as $curr) {
                // Adding all data to frameData
                $newKey = $curr['device'];
                $_SESSION['frameData'][(string)$newKey] = $curr;
            }

            // Sort by increasing width
            uasort($_SESSION['frameData'], function($first, $second){
                return (int)$first['width'] > (int)$second['width'];
            });

        }

        foreach($_SESSION['frameData'] as $curr){
            if($source == "width" || $curr['selected'] == "true"){
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
        }

        //echo "<pre>".print_r($_SESSION['frameData'])."</pre>";

    } // End of createNewFrames


    /**
     * addToFrameData - Searches json data for a new
     * @param String $deviceName Name of device to search for frameData
     * @return null
     */
    function addToFrameData($deviceName){

        $deviceName = trim($deviceName);
        $deviceName = str_replace(" ", "", $deviceName);

        $leftParenIdx = strpos($deviceName, "(");

        // Just grabbing device name & removing any extra whitespace
        $deviceName = trim(substr($deviceName, 0, $leftParenIdx));

        if(isset($_SESSION['frameData'][$deviceName])){

            if($_SESSION['frameData'][$deviceName]['selected'] != "true"){
                // if device exists, set selected to true
                $_SESSION['frameData'][$deviceName]['selected'] = "true";
            }
        }
        // Just regenerate frames
        regenFrames();
    } // End of addToFrameData


    /**
     * removeFromFrameData - Attempts to find a given device in the frameData
     *      variable, and switches selected field to false - if not already set.
     *
     * @param  String $deviceName - name of device plus its dimensions
     * @return null
     */
    function removeFromFrameData($deviceName){
        $deviceName = trim($deviceName);
        $deviceName = str_replace(" ", "", $deviceName);

        $leftParenIdx = strpos($deviceName, "(");

        // Just grabbing device name & removing any extra whitespace
        $deviceName = trim(substr($deviceName, 0, $leftParenIdx));

        if(isset($_SESSION['frameData'][$deviceName])){

            if($_SESSION['frameData'][$deviceName]['selected'] != "false"){
                // if device exists, set selected to true
                $_SESSION['frameData'][$deviceName]['selected'] = "false";
            }
        }
        // regenerate frames
        regenFrames();

    } // End of removeFromFrameData


    /**
     * regenFrames - Echo out all device objects in frameData if selected is true
     * @return null
     */
    function regenFrames(){

        foreach($_SESSION['frameData'] as $curr){

            if($curr['selected'] == "true"){
                // Place each iframe and it's width title together in one div
                echo "<div class='frame-holder'>";

                // device name and its dimensions
                $output = $curr['device']." (".$curr["width"]."x".$curr["height"].")";
                echo "<span>".$output."</span>";
                echo "<iframe src='".$_SESSION['url']."' ";
                echo "width='".$curr['width']."' height='500'>";
                echo "</iframe>";
                echo "</div>\n\t\t\t\t";
            }

        }
        // echo print_r($_SESSION['frameData']);

    } // End of regenFrames

?>
