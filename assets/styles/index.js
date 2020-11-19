import {startCam} from "./js/webcam";
import * as faceapi from "face-api.js";

const MODELS_URL = '/fd-models';
//const statusDiv = document.getElementById("match-result");
const initData = async () => {
    //statusDiv.innerText = "Loading models...";
    await faceapi.loadFaceDetectionModel(MODELS_URL);
    await faceapi.loadFaceRecognitionModel(MODELS_URL);
    await faceapi.loadSsdMobilenetv1Model(MODELS_URL);
    await faceapi.loadFaceLandmarkModel(MODELS_URL);
};

const checkface = async () => {
    //statusDiv.innerText = "Initializing...";
    await startCam();
    const video = document.getElementById("camera-feed");
    video.addEventListener('play', () => {
        const canvas = faceapi.createCanvasFromMedia(video);
        video.parentNode.append(canvas);
        const cameraDimensions = { width: video.offsetWidth, height: video.offsetHeight };
        faceapi.matchDimensions(canvas, cameraDimensions);
        $('#idrun').on('click',async function (){
            $('#state_data').text('Analyse en cours ... ');
            $('#state_data').attr("class","color-block info-color z-depth-2");
            const results = await faceapi.detectSingleFace("camera-feed").withFaceLandmarks().withFaceDescriptor();
            if(results){
                $('#data').val('['+results.descriptor.toString()+']');
                $('#state_data').attr("class","color-block success-color z-depth-2");
                $('#state_data').text('les données ont été bien analysées');
                $('#submitButton').removeAttr('disabled');
            }else{
                $('#state_data').attr("class","color-block danger-color z-depth-2");
                $('#state_data').text('Les données n\'ont pas été analysées Correctement , veuillez réessayer SVP !!!');
                $('#submitButton').attr("disabled","disabled");
            }
        });
        setInterval(async () => {
            const results = await faceapi.detectSingleFace("camera-feed").withFaceLandmarks().withFaceDescriptor().run();
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            if (results) {
                faceapi.draw.drawDetections(canvas, faceapi.resizeResults(results, cameraDimensions));
            }
        }, 100);
    });
};

initData().then(() => {
    checkface();
});
