const videoElement = document.getElementById("camera-feed");

export const startCam = async () => {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        videoElement.srcObject = await navigator.mediaDevices.getUserMedia({video: true, audio: false});
        videoElement.onloadedmetadata = () => {
            videoElement.play();
        };
    } else {
        console.error("getUserMedia is unsupported");
    }
};
