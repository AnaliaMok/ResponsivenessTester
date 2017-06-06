<?php
    // Constant array for storing set screen widths
    $COMMON_WIDTHS = array(240, 320, 768, 1024, 1366, 1440, 1920);
    // Default url to use for displaying iframes
    //$url = "";

    // including methods defined in filer.php - handles all form validation
    include "filter.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Responsive Testing</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <script type="text/javascript" src="assets/js/main.js"></script>
    </head>
    <body>
        <!--
            Display Options:
            - Width Only
            - By device (2 Dropdowns)
                - Apple Devices (up to 5 at a time)
                - Android Devices (up to 5 at a time)
        -->
        <main>
            <div id="url-input-holder">
                <h2>Current URL:</h2>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="urlForm">
                    <input type="text" name="url" placeholder="Enter url here"
                    id="url-input">
                    <input type="hidden" name="task" value="changeURL">
                </form>
            </div><!-- End of url-input-holder -->
            <div id="device-inputs">
                <!-- Option Radio Buttons -->
                <div id="displayButtons">
                    <h2>Display Options:</h2>
                    <input type="radio" name="displayOptions" value="width" id="width" checked>
                    <label for="width">By width</label>
                    <input type="radio" name="displayOptions" value="device" id="device">
                    <label for="device">By device</label>

                    <!-- Dropdowns for Apple & Android Devices -->
                    <?php
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
                                echo "</option>";
                            }
                        }
                    ?>
                </div><!-- End of displayButtons -->
                <div id="deviceOptions">
                    <form class="appleDeviceSelection" action="filter.php" method="get">
                        <p>Apple Devices</p>
                        <select name="apple-devices">
                            <?php fillDropdowns("assets/data/apple_devices.json"); ?>
                        </select>

                        <!-- Add device to view output area -->
                        <input type="submit" value="Add">
                        <button type="button" name="delete" id="del-btn">Remove</button>
                    </form>

                    <form class="androidDeviceSelection" action="filter.php" method="get">
                        <p>Android Devices</p>
                        <select name="android-devices">
                            <?php fillDropdowns("assets/data/android_devices.json"); ?>
                        </select>

                        <!-- Add device to view output area -->
                        <input type="submit" value="Add">
                        <button type="button" name="delete" id="del-btn">Remove</button>
                    </form>
                </div><!-- End of deviceOptions-->
            </div><!-- End of inputs -->

            <!-- Where various screens are displayed -->
            <div id="output">
                <?php
                    foreach($COMMON_WIDTHS as $curr){
                        echo "<iframe src='".$url."' ";
                        echo "width='".$curr."' height='500'>";
                        echo "</iframe>";
                    }
                ?>
            </div><!-- End of output -->
        </main>
    </body>
</html>
