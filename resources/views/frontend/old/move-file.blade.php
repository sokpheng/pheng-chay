<html>
  <head></head>
  <body>
    <script type="text/javascript">
      function handleClientLoad() {
        // Loads the client library and the auth2 library together for efficiency.
        // Loading the auth2 library is optional here since `gapi.client.init` function will load
        // it if not already loaded. Loading it upfront can save one network request.
        gapi.load('client:auth2', initClient);
      }

      function initClient() {
        // Initialize the client with API key and People API, and initialize OAuth with an
        // OAuth 2.0 client ID and scopes (space delimited string) to request access.
        gapi.client.init({
            apiKey: 'AIzaSyBpDFQdnutxEqQ4aYidHmMWm97QJpByXAU',
            discoveryDocs: ["https://www.googleapis.com/discovery/v1/apis/drive/v3/rest"],
            clientId: '122421306428-0sm852mhg2r1c2oeec0kdhmihs3udfs7.apps.googleusercontent.com',
            scope: 'https://www.googleapis.com/auth/drive.metadata.readonly https://www.googleapis.com/auth/drive.metadata.readonly'
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
        });
      }

      function updateSigninStatus(isSignedIn) {
        // When signin status changes, this function is called.
        // If the signin status is changed to signedIn, we make an API call.
        if (isSignedIn) {
          makeApiCall();
        }
      }

      function handleSignInClick(event) {
        // Ideally the button should only show up after gapi.client.init finishes, so that this
        // handler won't be called before OAuth is initialized.
        gapi.auth2.getAuthInstance().signIn();
      }

      function handleSignOutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
      }

      function makeApiCall() {
        // Make an API call to the People API, and print the user's given name.
        // var fileId = '1lf-9CaPbmbNIH3P-gfCP2m1GAA3MArWfrfvt1a3ZYMQ';
        var fileId = '1LWhEEm9_Uhfzqc1z8nzW6vLppaaJShg7qoJ4NxU4vT0';
        
        var folderId = '0Bxmp0zTnF53LS2FsNDhYd1FxM1U';
        // Retrieve the existing parents to remove
        console.log('work');
        gapi.client.drive.files.get({
          fileId: fileId,
          fields: 'parents'
        }).then(function(result) {
          


          var file = result.result;

          console.log(file);

          if (!file) {
            // Handle error
            console.log(file);
          } else {
            // Move the file to the new folder
            var previousParents = file.parents.join(',');
            gapi.client.drive.files.update({
              fileId: fileId,
              addParents: folderId,
              removeParents: previousParents,
              fields: 'id, parents'
            }).then(function(res) {
                // File moved.
                console.log('moved',res);
            },function(err){
              console.log(err);
            });
          }
        },function(err){
          console.log(err);
        });
      }
    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
    <button id="signin-button" onclick="handleSignInClick()">Sign In</button>
    <button id="signout-button" onclick="handleSignOutClick()">Sign Out</button>
  </body>
</html>