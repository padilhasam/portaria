<div class="modal fade" id="modalCamera" tabindex="-1" role="dialog" aria-labelledby="modalCamera" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Captura Selfie</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div style="width:100%">
                <video id="cam" autoplay muted playsinline class="w-100 rounded-lg">Not available</video>
                <canvas id="canvas" class="d-none w-100 rounded-lg"></canvas>  
            </div>
        </div>
        <div class="modal-footer d-flex gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="snapBtn" class="btn btn-primary" data-bs-dismiss="modal">Capturar</button>
        </div>
        </div>
    </div>
</div>

<script>
    // reference to the current media stream
    var mediaStream = null;

    // Prefer camera resolution nearest to 1280x720.
    var constraints = { 
    audio: false, 
    video: { 
        width: {ideal: 640}, 
        height: {ideal: 480},
        facingMode: "environment"
    } 
    }; 

    async function getMediaStream(constraints) {
    try {
        mediaStream =  await navigator.mediaDevices.getUserMedia(constraints);
        let video = document.getElementById('cam');    
        video.srcObject = mediaStream;
        video.onloadedmetadata = (event) => {
        video.play();
        };
    } catch (err)  {    
        console.error(err.message);   
    }
    };

    async function switchCamera(cameraMode) {  
    try {
        // stop the current video stream
        if (mediaStream != null && mediaStream.active) {
        var tracks = mediaStream.getVideoTracks();
        tracks.forEach(track => {
            track.stop();
        })      
        }
        
        // set the video source to null
        document.getElementById('cam').srcObject = null;
        
        // change "facingMode"
        constraints.video.facingMode = cameraMode;
        
        // get new media stream
        await getMediaStream(constraints);
    } catch (err)  {    
        console.error(err.message); 
        alert(err.message);
    }
    }

    function takePicture() {  
    let canvas = document.getElementById('canvas');
    let video = document.getElementById('cam');
    let photo = document.getElementById('photo');  
    let context = canvas.getContext('2d');
    
    const height = video.videoHeight;
    const width = video.videoWidth;
    
    if (width && height) {
        $('#user-image').val('')
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);    
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    } else {
        clearphoto();
    }
    }

    function clearPhoto() {
    let canvas = document.getElementById('canvas');
    let photo = document.getElementById('photo');
    let context = canvas.getContext('2d');
    
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
    }

    document.getElementById('switchFrontBtn').onclick = (event) => {
    switchCamera("user");
    }

    // document.getElementById('switchBackBtn').onclick = (event) => {  
    // switchCamera("environment");
    // }

    document.getElementById('snapBtn').onclick = (event) => {  
    takePicture();
    event.preventDefault();
    }

    // clearPhoto();
</script>