function getAllMatches(node){
    fetch('/api/allMatches').then((response)=>{
        return response.json();
    },(error)=>{
        console.log(error)
    }).then((data)=>{
        console.log((data));
        data.forEach(element =>{
            let sectionMatch = document.querySelector(".allMatches");
            let matchSection = document.createElement("a");
            // let matchResult = document.createElement("p");
            let equipe1 = document.createElement("p");
            let equipe2 = document.createElement("p");
            let dateHeure = document.createElement("p");
            let equipeLocal = document.createElement("p");
            let situationMatch = document.createElement("p");
            equipeLocal.innerText = element.hote;
            dateHeure.innerText = element.dateHeure;
            equipe1.innerText = element.equipeAdverse;
            equipe2.innerText = element.equipeLocale;
            situationMatch.innerText = element.gymnase;

            matchSection.appendChild(equipe1)
            matchSection.appendChild(equipe2)
            matchSection.appendChild(dateHeure)
            matchSection.appendChild(equipeLocal)
            matchSection.appendChild(situationMatch)

            sectionMatch.appendChild(matchSection)

        })
    })

}
getAllMatches();