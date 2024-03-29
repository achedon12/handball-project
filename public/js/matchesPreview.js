let date;

let remainingTime = document.querySelector(".next-match-remaining-time").querySelector('p');
setInterval(() => {
    let remaining = getRemainingTime(date);
    console.log(remaining)
    remainingTime.hidden = isNaN(remaining[0]);
    if (remaining !== [0, 0, 0, 0]) {
        remainingTime.innerHTML = remaining[0] + "<dt>j</dt>" + remaining[1] + "<dt>h</dt>" + remaining[2] + "<dt>m</dt>" + remaining[3] + "<dt>s</dt>";
    }
}, 1000);


getMatch("next");
getMatch("last");


function getRemainingTime(date) {
    let now = new Date();
    let diff = date - now;
    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
    let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((diff % (1000 * 60)) / 1000);
    return [days, hours, minutes, seconds];
}

function getMatch(type) {
    if (!type in ['last', 'next']) {
        console.error("getMatch : argument 'type' unknown")
        return;
    }
    fetch("/api/" + type + "match")
        .then((response) => {
            return response.json();
        }, (error) => {
            console.log(error);
        })
        .then((data) => {
            data = data[0];
            // console.log(data);

            let dateMatch = new Date(data.dateHeure.split('+')[0]);
            if (type === 'next') {
                date = dateMatch
            }
            let dateElement = document.querySelector("." + type + "-match-date");
            let timeElement = document.querySelector("." + type + "-match-time");
            let opponentElement = document.querySelector("." + type + "-match-team2");
            let us = document.querySelector("." + type + "-match-team1");
            let locationElement = document.querySelector("." + type + "-match-location");
            dateElement.innerHTML = new Intl.DateTimeFormat("fr-FR", {
                weekday: "long", day: "numeric", month: "long", year: "numeric"
            }).format(dateMatch);
            timeElement.innerHTML = new Intl.DateTimeFormat("fr-FR", {
                hour: "2-digit", minute: "2-digit"
            }).format(dateMatch);
            if (data.domicileExterieur === 0) {
                us.innerHTML = data.equipeLocale;
                opponentElement.innerHTML = data.equipeAdverse;
            } else {
                us.innerHTML = data.equipeAdverse;
                opponentElement.innerHTML = data.equipeLocale;
            }
            locationElement.appendChild(document.createTextNode(data.gymnase));
        });
}

