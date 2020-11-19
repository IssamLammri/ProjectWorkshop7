import {startCam} from "./js/webcam";
import * as faceapi from "face-api.js";
import AuthorizedPerson from "./js/models/AuthorizedPerson";

let resedent ;
let routine;
let canvas ;
const MODELS_URL = '/fd-models';
//const statusDiv = document.getElementById("match-result");
const initData = async () => {
    await faceapi.loadFaceDetectionModel(MODELS_URL);
    await faceapi.loadFaceRecognitionModel(MODELS_URL);
    await faceapi.loadSsdMobilenetv1Model(MODELS_URL);
    await faceapi.loadFaceLandmarkModel(MODELS_URL);

};

const initPersApprt = async () =>{
    //statusDiv.innerText = "Loading models...";
    var idres = $('#choixappart option:selected').attr('id');
    resedent = await fetch('/findpersappert',{method:'POST', body : JSON.stringify({'idss' : idres})});
    //console.log(await resedent.json());
    resedent = AuthorizedPerson.parsResidence(await resedent.json());
    //console.log(resedent);
    await initData();
}

const initPersRes = async () =>{
    //statusDiv.innerText = "Loading models...";
    var idres = $('#choixMagasin option:selected').attr('id');
    console.log(idres);
    resedent = await fetch('/findresi',{method:'POST', body : JSON.stringify({'idss' : idres})});
    //console.log(await resedent.json());
    resedent = AuthorizedPerson.parsResidence(await resedent.json());
    //console.log(resedent);
    await initData();
}

const compareFaces = async descriptors => {
    if (!descriptors || !descriptors.length) {
        return;
    }
    //statusDiv.innerText = "Initializing...";
    await startCam();
    const video = document.getElementById("camera-feed");

    video.addEventListener('play', () => {
        let succ1 = document.getElementById("succ");
        let fail1 = document.getElementById("fail");
        canvas = faceapi.createCanvasFromMedia(video);
        //document.body.appendChild(canvas);
        video.parentElement.prepend(canvas);
        const cameraDimensions = { width: video.clientWidth, height: video.clientHeight };
        faceapi.matchDimensions(canvas, cameraDimensions);
        const faceMatcher = new faceapi.FaceMatcher(descriptors);
        //statusDiv.remove();
        let block = false;
        routine = setInterval(async () => {
            const results = await faceapi
                .detectAllFaces(video)
                .withFaceLandmarks()
                .withFaceDescriptors();
            if (results && results.length) {
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                faceapi.draw.drawFaceLandmarks(canvas, faceapi.resizeResults(results, cameraDimensions));
                let succes = false;
                for (const fd of results) {

                    const match = faceMatcher.findBestMatch(fd.descriptor);
                    if (match && match.distance < 0.6) {
                        succes= true;
                        (new faceapi.draw.DrawBox(fd.detection.box, {label: [match.label, `Distance: ${match.distance.toFixed(3)}`]})).draw(canvas);
                        continue;
                    }
                    (new faceapi.draw.DrawBox(fd.detection.box, {label: "Unknown person", boxColor: "red"})).draw(canvas);
                }
                if (!block){
                    if (succes){
                        block =true;
                        setTimeout(() =>{
                            block=false;
                            succ1.style.display='none';
                            fail1.style.display='none';
                        },15000);
                        succ1.style.display='block';
                        fail1.style.display='none';
                    }else{
                        block =true;
                        setTimeout(() =>{
                            block=false;
                            succ1.style.display='none';
                            fail1.style.display='none';
                        },3000);
                        fail1.style.display='block';
                        succ1.style.display='none';
                    }
                }
                return;
            }
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        }, 50);
    });
};

$(document).ready(function(){
    $("#loadstudent").on("click", function(event){
        var idres = $('#choixMagasin option:selected').attr('id');
        $.ajax({
            url:        '/findappar',
            type:       'POST',
            data : {'idss' : idres},
            dataType:   'json',
            async:      true,

            success: function(data, status) {
                $('#divappr').html('');

                for(let i = 0; i < data.length; i++) {
                    const student = data[i];
                    var e = $('<label class="btn form-check-label aqua-gradient ">\n' +
                        '                    <input class="form-check-input" type="radio" name="options" id="option" autocomplete="off" >\n' +
                        '                    '+student['NumApp']+'\n' +
                        '                </label>');
                    $('#divappr').append(e);
                }
            },
            error : function(xhr, textStatus, errorThrown) {
                alert('Ajax request xxxxxxxxxxxxxx.');
            }
        });
    });
});
let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");
let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");
togg1.addEventListener("click", () => {
    if (canvas){
        canvas.remove();
    }
    clearInterval(routine);
    initPersRes()
        .then(() => {compareFaces(AuthorizedPerson.generateLabeledFaceDescriptors(resedent))});

    if(getComputedStyle(d1).display != "none"){
        d1.style.display = "none";
    } else {
        d1.style.display = "block";
    }
})
togg2.addEventListener("click", () => {
    if (canvas){
        canvas.remove();    }
    clearInterval(routine);
    initPersApprt()
        .then(() => {compareFaces(AuthorizedPerson.generateLabeledFaceDescriptors(resedent))});
    if(getComputedStyle(d1).display != "none"){
        d1.style.display = "none";
    } else {
        d1.style.display = "block";
    }
})
function togg(){
    if(getComputedStyle(d2).display != "none"){
        d2.style.display = "none";
    } else {
        d2.style.display = "block";
    }
};
togg2.onclick = togg;
