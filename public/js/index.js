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

let newElement = document.querySelectorAll(".news-element");
newElement.forEach((element) => {
    element.addEventListener("mouseout", () => {
        element.classList.remove("hover");
        newElement.forEach((element2) => {
           if(element !== element2){
               element2.classList.remove("notHover");
           }
        });
    });

    element.addEventListener("mouseover", () => {
        element.classList.add("hover");
        newElement.forEach((element2) => {
            if(element !== element2){
                element2.classList.add("notHover");
            }
        });
    });
});