<?php
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
                    id="url-input" value="<?php echo ($url != "./placeholder.html") ? $url: "" ?>">
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

                </div><!-- End of displayButtons -->
                <div id="deviceOptions">
                    <!-- Dropdowns for Apple & Android Devices -->
                    <form class="appleDeviceSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <p>Apple Devices</p>
                        <select name="apple-devices">
                            <?php fillDropdowns("assets/data/apple_devices.json"); ?>

                        </select>

                        <!-- Add device to view output area -->
                        <input type="submit" value="Add">
                        <button type="button" name="delete" class="del-btn">Remove</button>
                    </form>

                    <form class="androidDeviceSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <p>Android Devices</p>
                        <select name="android-devices">
                            <?php fillDropdowns("assets/data/android_devices.json"); ?>

                        </select>

                        <!-- Add device to view output area -->
                        <input type="submit" value="Add">
                        <button type="button" name="delete" class="del-btn">Remove</button>
                    </form>
                </div><!-- End of deviceOptions-->
            </div><!-- End of inputs -->
        </main>
        <!-- Where various screens are displayed -->
        <div id="output"></div><!-- End of output -->
    </body>
</html>
