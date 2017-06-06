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

    // Fill output div
    changeFrames("width");

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

} // End of toggleOptionDisplay


/**
 * changeFrames - Method for changing what iframes are to be displayed in the
 *      output div based on the given source. Makes an AJAX call to filter.php
 *      to change frames.
 * @param  source - A String indicating what iframes ot display.
 * @return {[type]}        [description]
 */
function changeFrames(source){
    // Send AJAX request to change device options
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("output").innerHTML = this.responseText;
        }
    };

    /* TODO: Change to post */
    xmlhttp.open("GET", "filter.php?source=" + source, true);
    xmlhttp.send();

} // End of changeFrames
