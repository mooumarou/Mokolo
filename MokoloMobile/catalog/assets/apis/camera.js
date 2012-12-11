

    /**
* Take picture with camera
*/
    function takePicture() {
        navigator.camera.getPicture(
    		function(uri) {
        		document.getElementById('picturepath').innerHTML = uri;
            },
            function(e) {
                console.log("Error getting picture: " + e);
                document.getElementById('camera_status').innerHTML = "Error getting picture.";
            },
            { quality: 50, destinationType: navigator.camera.DestinationType.FILE_URI});
    };

    /**
* Select picture from library
*/
    function selectPicture() {
        navigator.camera.getPicture(
        	function(uri) {
        		document.getElementById('picturepath').innerHTML = uri;
            },
            function(e) {
                console.log("Error getting picture: " + e);
                document.getElementById('camera_status').innerHTML = "Error getting picture.";
            },
            { quality: 50, destinationType: navigator.camera.DestinationType.FILE_URI, sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY});
    };
    
    /**
* Upload current picture
*/
    function uploadPicture(imageURI) {
        
        // Verify server has been entered
        server = "create_product_handle.php";
        if (server) {
        
            // Specify transfer options
            var options = new FileUploadOptions();
            options.fileKey="file";
            options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
            options.mimeType="image/jpeg";
            options.chunkedMode = false;

            // Transfer picture to server
            var ft = new FileTransfer();
            ft.upload(imageURI, server, function(r) {
                document.getElementById('camera_status').innerHTML = "Upload successful: "+r.bytesSent+" bytes uploaded.";
            }, function(error) {
                document.getElementById('camera_status').innerHTML = "Upload failed: Code = "+error.code;
            }, options);
        }
    }
    
    /**
* Function called when page has finished loading.
*/
    function init() {
        
    }