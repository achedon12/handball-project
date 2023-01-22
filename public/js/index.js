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

let date;

fetch("/api/nextmatch")
    .then((response) => {
        return response.json();
    },
    (error) => {
        console.log(error);
    })
    .then((data) => {
        data = data[0];
        date = new Date(data.dateHeure);
        let dateElement = document.querySelector(".next-match-date");
        let timeElement = document.querySelector(".next-match-time");
        let opponentElement = document.querySelector(".next-match-team2");
        let us = document.querySelector(".next-match-team1");
        let locationElement = document.querySelector(".next-match-location");
        dateElement.innerHTML = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        timeElement.innerHTML = date.getHours() + ":" + date.getMinutes();
        if(data.domicileExterieur === 0){
            us.innerHTML = "GGAHB";
            opponentElement.innerHTML = data.equipeAdverse;
        }else{
            us.innerHTML = data.equipeAdverse;
            opponentElement.innerHTML = "US";
        }
        locationElement.innerHTML = data.gymnase;
    });


let remainingTime = document.querySelector(".next-match-remaining-time");
setInterval(() => {
    remainingTime.innerHTML = getRemainingTime(date);
},1000);

function getRemainingTime(date){
    let now = new Date();
    let diff = date - now;
    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
    let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((diff % (1000 * 60)) / 1000);
    return days + "j " + hours + "h " + minutes + "m " + seconds + "s";
}

fetch("/api/lastmatch")
    .then((response) => {
            return response.json();
        },
        (error) => {
            console.log(error);
        })
    .then((data) => {
        data = data[0];
        date = new Date(data.dateHeure);
        let dateElement = document.querySelector(".last-match-date");
        let timeElement = document.querySelector(".last-match-time");
        let opponentElement = document.querySelector(".last-match-team2");
        let us = document.querySelector(".last-match-team1");
        let locationElement = document.querySelector(".last-match-location");
        dateElement.innerHTML = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        timeElement.innerHTML = date.getHours() + ":" + date.getMinutes();
        if(data.domicileExterieur === 0){
            us.innerHTML = "GGAHB";
            opponentElement.innerHTML = data.equipeAdverse;
        }else{
            us.innerHTML = data.equipeAdverse;
            opponentElement.innerHTML = "US";
        }
        locationElement.innerHTML = data.gymnase;
    });
