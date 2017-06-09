/**
 * File Name: main.js
 * Description: Main javascript file that contains all methods for manipulating
 *      what the iframes will display, the dimensions of each iframe, and the
 *      total number of iframes that will be displayed.
 */

window.onload = init;


/**
 * init - Method for assigning event methods for various
 *      DOM elements
 * @return null
 */
function init(){
    // URL Input
    var urlInput = document.getElementById("url-input");
    // Method used to submit the url form when user presses enter
    urlInput.onkeydown = submitURLForm;

    // Radio Buttons
    var widthRadioBtn = document.getElementById("width");
    var deviceRadioBtn = document.getElementById("device");
    widthRadioBtn.onclick = toggleOptionDisplay;
    deviceRadioBtn.onclick = toggleOptionDisplay;

    // Device Selection Add & Remove Buttons
    var appleButtons = document.getElementById("appleDeviceSelection")
                               .getElementsByClassName("apple");
    appleButtons[0].onclick = addDevice;
    appleButtons[1].onclick = removeDevice;

    var androidButtons = document.getElementById("androidDeviceSelection")
                                 .getElementsByClassName("android");
    androidButtons[0].onclick = addDevice;
    androidButtons[1].onclick = removeDevice;

} // End of init


/**
 * changeURL - submits url form
 * @return null
 */
function submitURLForm(){

    if(window.event.keyCode == "13"){
        // if enter key pressed
        document.urlForm.method = "post";
        document.urlForm.submit();
    }

} // End of submitURLForm


/**
 * findDevice - Given a button object, tries to find the respective dropdown
 *      group and returns the dropdowns current value
 * @param  Node button - A Button object
 * @return String current value of either of the two dropdown
 */
function findDevice(button){

    // Index 0 will always contain the device type
    var deviceType = button.classList[0];
    var deviceName = "";

    switch (deviceType) {
        case "apple":
            deviceName =  document.getElementById("appleDevices").value;
            if(deviceName != ""){
                return deviceName;
            }
            break;
        case "android":
            deviceName =  document.getElementById("androidDevices").value;
            if(deviceName != ""){
                return deviceName;
            }
            break;
        default:
            console.log("ERROR: Unknown device type found: " + deviceType);
            return null;
    }

    // If reached, no value was found for device
    console.log("ERROR: No device value found");
    return null;

} // End of findDevice


/**
 * addDevice - Given a device name, an AJAX call will be made to filter.php
 *      to find the device object. If any, the responseText will replace the
 *      current HTML inside div#output.
 *      NOTE: Attempts to add an already selected device will not cause an error
 *          The exact same HTML that's already present will be outputted by filter.php
 *      NOTE: responseText will be sorted by width of the selected devices
 */
function addDevice(){
    // NOTE: 'this' will refer to button itself

    var deviceName = findDevice(this);

    console.log(deviceName);

} // End of addDevice


/**
 * removeDevice - Given a device name, an AJAX call will be made to filter.php
 *      to remove a device object from the frameData associative array.
 *
 */
function removeDevice(){
    // NOTE: 'this' will refer to button itself

    var deviceName = findDevice(this);

} // End of removeDevice


/**
 * toggleOptionDisplay - Toggle the visibility of the
 *      device display options
 * @return {[type]} [description]
 */
function toggleOptionDisplay(){
    // Div holding the device display options
    var deviceOptions = document.getElementById("deviceOptions");

    // String to pass with AJAX request
    var source = "";

    if(this.value === "width"){
        // Hide on width based testing
        deviceOptions.style.display = "none";
        source = "width"
    }else{
        // Show on device-based testing
        deviceOptions.style.display = "inline-block";
        source = "device";
    }

    // Change what frames are being displayed
    changeFrames(source);

} // End of toggleOptionDisplay


/**
 * changeFrames - Method for changing what iframes are to be displayed in the
 *      output div based on the given source. Makes an AJAX call to filter.php
 *      to change frames.
 * @param  source - A String indicating what iframes ot display.
 * @return null
 */
function changeFrames(source){
    // Send AJAX request to change device options
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("output").innerHTML = this.responseText;
            /* TODO: Change width of output based on frames */
        }
    };

    /* TODO: Change to post */
    xmlhttp.open("POST", "filter.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Grab current url
    var currURL = document.getElementById("url-input").value;
    var params = "source="+source+"&url="+currURL;
    xmlhttp.send(params);

} // End of changeFrames
