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
        $('#idrun').on('click',async function (){
            const results = await faceapi.detectSingleFace("camera-feed").withFaceLandmarks().withFaceDescriptor();
            if(results){
                var resultfin = '['+results.descriptor.toString()+']';
                console.log(resultfin);
                $('#data').val(resultfin);
                $('#state_data').attr("class","color-block success-color z-depth-2");
                $('#state_data').text('La DATA a été bien analysé');
                $('#submitButton').removeAttr('disabled');
            }else{
                $('#state_data').attr("class","color-block danger-color z-depth-2");
                $('#state_data').text('La DATA n\'a pas été analysé Correctement , VEUILLEZ Réessayer SVP !!!');
                $('#submitButton').attr("disabled","disabled");
            }
        });
        //const faceMatcher = new faceapi.FaceMatcher(descriptors);
        //statusDiv.remove();
        // setInterval(async () => {
        //     const results = faceapi.detectSingleFace("camera-feed").withFaceLandmarks().withFaceDescriptor();
        //     console.log(results);
        //     canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        // }, 2000);
    });
};

initData().then(() => {
    checkface();
});
