function getAllTeam(){
    fetch("/api/allTeam").then((response)=>{
        return response.json();
    }, (error)=>{
        console.log(error)
    }).then((data)=>{
        console.log(data[0]);
        data.forEach(element => {
            let sectionallTeam = document.querySelector(".allTeam")
            let teamSection = document.createElement("a");
            let teamImg = document.createElement('img');
            teamImg.src = "/images/" + element.urlPhoto;

            let teamName = document.createElement('h2');
            teamName.innerText = element.libelle;
            let teamSchedules = document.createElement("p");
            if (element.creneaux===""){
                teamSchedules.innerText = "Pas de créneau prévue";
            }else{
            teamSchedules.innerText = element.creneaux;
            }
            teamSection.appendChild(teamImg);
            teamSection.appendChild(teamName);
            teamSection.href= "/equipe/show/"+element.id

            teamSection.appendChild(teamSchedules);
            teamSection.classList.add("teamArticle")


            sectionallTeam.appendChild(teamSection);
        })
        let load = document.getElementById("loader");
        load.remove();

    })
}
getAllTeam();