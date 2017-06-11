<?php
    // Starting a session
    if(!isset($_SESSION)){
        session_start();
    }

    // URL used by the iframes - by default, just current page
    $_SESSION['url'] = "./placeholder.html";

    // Empty array holding the titles and dimensions of the iframes
    //$frameData = array();

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
                <!-- TODO: Change action to use ajax instead -->
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="urlForm">
                    <input type="text" name="url" placeholder="Enter url here"
                    id="url-input" value="<?php echo ($_SESSION['url'] != "./placeholder.html") ? $_SESSION['url']: "" ?>">
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
                    <div id="appleDeviceSelection">
                        <p>Apple Devices</p>
                        <select id="appleDevices">
                            <?php fillDropdowns("assets/data/apple_devices.json"); ?>

                        </select>

                        <!-- Add device to view output area -->
                        <!-- Might change to buttons -->
                        <button type="button" name="add" class="apple add-btn">Add</button>
                        <button type="button" name="delete" class="apple del-btn">Remove</button>
                    </div><!-- appleDeviceSelection -->

                    <div id="androidDeviceSelection">
                        <p>Android Devices</p>
                        <select id="androidDevices">
                            <?php fillDropdowns("assets/data/android_devices.json"); ?>

                        </select>

                        <!-- Add device to view output area -->
                        <button type="button" name="add" class="android add-btn">Add</button>
                        <!-- Remove device to view output area -->
                        <button type="button" name="delete" class="android del-btn">Remove</button>
                    </div><!-- End of androidDeviceSelection -->
                </div><!-- End of deviceOptions-->

            </div><!-- End of inputs -->
        </main>
        <!-- Where various screens are displayed -->
        <div id="output">
            <?php createNewFrames("width", $_SESSION['url']); ?>
        </div><!-- End of output -->

    </body>
</html>
