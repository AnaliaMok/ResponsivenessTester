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
            <h2>Current URL:</h2>
            <input type="text" name="url" placeholder="Enter url here" id="url-input" onkeydown="return changeURL(event);">

            <h2>Display Options:</h2>

            <!-- Option Radio Buttons -->
            <div id="displayButtons">
                <input type="radio" name="displayOptions" value="width" id="width" checked>
                <label for="width">By width</label>
                <input type="radio" name="displayOptions" value="device" id="device">
                <label for="device">By device</label>

                <!-- Dropdowns for Apple & Android Devices -->
                <?php
                    function fillDropdowns($filePath){
                        $fileContents = file_get_contents($filePath);
                        $data = json_decode($fileContents, true);

                        $totalItems = count($data);
                        for($i = 0; $i < $totalItems; $i++){
                            $currItem = $data[$i];
                            echo "<option>";
                            $width = str_replace("px", "", $currItem["width"]);
                            $height = str_replace("px", "", $currItem["height"]);
                            echo $currItem["device"]." (".$width."x".$height.")";
                            echo "</option>";
                        }
                    }
                ?>

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
            </div><!-- End of displayButtons -->

            <!-- Where various screens are displayed -->
            <div id="output">
                <!-- 240 (really small),
                    320, 768, 1024, 1366, 1440, 1920, 3200 (really big)
                -->
            </div>

        </main>

    </body>
</html>
