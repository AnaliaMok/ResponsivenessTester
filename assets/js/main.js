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
} // End of init


/**
 * changeURL - submits url form
 * @return null
 */
function submitURLForm(){

    if(window.event.keyCode == "13"){
        // if enter key pressed
        document.urlForm.submit();
        document.urlForm.method = "post";
    }

} // End of submitURLForm

/**
 * toggleOptionDisplay - Toggle the visibility of the
 *      device display options
 * @return {[type]} [description]
 */
function toggleOptionDisplay(){
    // Div holding the device display options
    var displayOptions = document.getElementById("deviceOptions");

    if(this.value === "width"){
        // Hide on width based testing
        displayOptions.style.display = "none";
    }else{
        // Show on device-based testing
        displayOptions.style.display = "inline-block";
    }
} // End of toggleOptionDisplay
