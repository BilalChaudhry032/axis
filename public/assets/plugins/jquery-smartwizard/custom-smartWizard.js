/*---------------------------------------------
Template name :  Dashmin
Version       :  1.0
Author        :  ThemeLooks
Author url    :  http://themelooks.com


** Custom SmartWizard JS

----------------------------------------------*/

$('#smartwizard').smartWizard({
    theme: 'arrows',
    autoAdjustHeight: false,
    enableURLhash: true,
    anchorSettings: {
        enableAllAnchors: true, // Activates all anchors clickable all times

        anchorClickable: true, // Enable/Disable anchor navigation
        markDoneStep: false, // Add done state on navigation
        markAllPreviousStepsAsDone: false, // When a step selected by url hash, all previous steps are marked done
        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
    },
    toolbarSettings: {
        toolbarPosition: 'none', // none, top, bottom, both
        showNextButton: false, // show/hide a Next button
        showPreviousButton: false, // show/hide a Previous button
    },
});


$('#smartwizard2').smartWizard();


