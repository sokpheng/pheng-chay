// The Browser API key obtained from the Google API Console.
// Replace with your own Browser API key, or your own key.
var developerKey = 'AIzaSyBpDFQdnutxEqQ4aYidHmMWm97QJpByXAU';

// The Client ID obtained from the Google API Console. Replace with your own Client ID.
var clientId = "122421306428-0sm852mhg2r1c2oeec0kdhmihs3udfs7.apps.googleusercontent.com"

// Replace with your own project number from console.developers.google.com.
// See "Project number" under "IAM & Admin" > "Settings"
var appId = "122421306428";

// Scope to use to access user's Drive items.
var scope = ['https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/spreadsheets'];

var pickerApiLoaded = false;
var oauthToken;

// Use the Google API Loader script to load the google.picker script.
function loadPicker() {
    gapi.load('client:auth2', {
        'callback': onAuthApiLoad
    });
    // gapi.load('picker', {
    //     'callback': onPickerApiLoad
    // });
    // gapi.load('drive', {
    //     'callback': moveFile
    // });


}

function onAuthApiLoad() {
    window.gapi.auth.authorize({
            'client_id': clientId,
            'scope': scope,
            'immediate': false
        },
        handleAuthResult);
}

function onPickerApiLoad() {
    pickerApiLoaded = true;
    createPicker();
}
// function onPickerApiLoad() {
//     pickerApiLoaded = true;
//     createPicker();
// }

function handleAuthResult(authResult) {

    if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        console.log(oauthToken);
        // createPicker();
        moveFile();
    }
}

function moveFile() {
    if (oauthToken) {

        // console.log('yes it work', drive);

        fileId = '1lf-9CaPbmbNIH3P-gfCP2m1GAA3MArWfrfvt1a3ZYMQ'
        folderId = '0Bxmp0zTnF53LSlJsYmg0SWxpUDQ'
            // Retrieve the existing parents to remove
        gapi.client.drive.files.get({
            fileId: fileId,
            fields: 'parents'
        }, function(err, file) {
            if (err) {
                // Handle error
                console.log(err);
            } else {
                // Move the file to the new folder
                var previousParents = file.parents.join(',');
                drive.files.update({
                    fileId: fileId,
                    addParents: folderId,
                    removeParents: previousParents,
                    fields: 'id, parents'
                }, function(err, file) {
                    if (err) {
                        // Handle error
                        console.log(err);

                    } else {
                        // File moved.
                        console.log('file moved', file);
                    }
                });
            }
        });


    }
}


// Create and render a Picker object for searching images.
function createPicker() {
    if (pickerApiLoaded && oauthToken) {

        console.log(google);

        var view = new google.picker.View(google.picker.ViewId.SPREADSHEETS);
        var view1 = new google.picker.View(google.picker.ViewId.FOLDERS);
        // view.setMimeTypes("image/png,image/jpeg,image/jpg");

        var docsView = new google.picker.DocsView()
            .setIncludeFolders(true)
            .setMimeTypes('application/vnd.google-apps.folder')
            .setSelectFolderEnabled(true);

        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            // .addView(view)
            // .addView(view1)
            .addView(docsView)
            // .addView(new google.picker.DocsUploadView())
            .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
        picker.setVisible(true);
    }
}

// A simple callback implementation.
function pickerCallback(data) {
    if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
        alert('The user selected: ' + fileId);
    }
}