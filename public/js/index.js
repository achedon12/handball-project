let imgCount = 1;
let images = [
    "Loisirs.jpg",
    "Moins9.jpg",
    "Moins11.jpg",
    "Moins13.jpg",
    "Moins15.jpg",
    "Moins17.jpg",
    "Moins18.jpg",
    "Seniors1et2.jpg",
    "SF1.jpg",
    "SF2.jpg"
];

let img = document.querySelector(".img");

setInterval(() => {
    imgCount++;
    if(imgCount - 1 >= images.length) {
        imgCount = 1;
    }
    img.src = "images/" + images[imgCount - 1];
    img.alt = images[imgCount - 1];
},10000);