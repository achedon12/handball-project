function getAllTeam(){
    fetch("/api/allTeam").then((response)=>{
        return response.json();
    }, (error)=>{
        console.log(error)
    }).then((data)=>{
        console.log(data[0]);
        data.forEach(element => {
            let sectionallTeam = document.querySelector(".allTeam")
            let teamSection = document.createElement("section");
            let infoSection = document.createElement("section");
            let slotSection = document.createElement('section');
            slotSection.classList.add('slotSection');
            infoSection.classList.add("infoSection");
            let teamImg = document.createElement('img');
            teamImg.src = "/images/" + element.urlPhoto;

            let teamName = document.createElement('h2');
            teamName.innerText = element.libelle;
            let teamSchedules = document.createElement("p");
            if (element.creneaux===""){
                let oneSchedules = document.createElement("p");
                oneSchedules.innerText = "Pas de créneau prévue";
                slotSection.appendChild(oneSchedules);
            }else{
                element.creneaux.split(',').forEach(creneau=>{
                        let oneSchedules = document.createElement("p");
                        oneSchedules.innerText = creneau;
                        slotSection.appendChild(oneSchedules);
                    }

                )

            }
            teamSection.appendChild(teamImg);


            infoSection.appendChild(teamName);
            infoSection.appendChild(slotSection);
            infoSection.appendChild(teamSchedules);
            teamSection.appendChild(infoSection)
            teamSection.classList.add("teamArticle")


            sectionallTeam.appendChild(teamSection);
        })
        let load = document.getElementById("loader");
        load.remove();

    })
}
getAllTeam();



function getTeamByID(id){
    fetch('/api/OneTeam/'+id)
        .then(response => response.json())
        .then(data =>{
            data

        })
}