function getAllTeam() {
    fetch("/api/allTeam").then((response) => {
        return response.json();
    }, (error) => {
        console.log(error)
    }).then((data) => {
        data.forEach(element => {
            let sectionallTeam = document.querySelector(".allTeam")
            let teamSection = document.createElement("section");
            let infoSection = document.createElement("section");
            let slotSection = document.createElement('section');
            slotSection.classList.add('slotSection');
            infoSection.classList.add("infoSection");
            let teamImg = document.createElement('img');
            let src = "/images/" + element.urlPhoto;
            if (isCripted(element.urlPhoto)) {
                src = "/uploads/images/" + element.urlPhoto;
            }
            teamImg.src = src;
            let teamName = document.createElement('h2');
            teamName.innerText = element.libelle;
            let teamSchedules = document.createElement("p");
            if (element.creneaux === "") {
                let oneSchedules = document.createElement("p");
                oneSchedules.innerText = "Pas de créneau prévue";
                slotSection.appendChild(oneSchedules);
            } else {
                element.creneaux.split(',').forEach(creneau => {
                        let oneSchedules = document.createElement("p");
                        oneSchedules.innerText = creneau;
                        slotSection.appendChild(oneSchedules);
                    }
                );
            }

            teamSection.appendChild(teamImg);

            infoSection.appendChild(teamName);
            infoSection.appendChild(slotSection);
            infoSection.appendChild(teamSchedules);

            let role = document.getElementById("role").textContent;
            if (role.trim() === 'ROLE_ADMIN') {
                let aEdit = document.createElement('a');
                let iEdit = document.createElement('i');
                iEdit.classList.add('bi');
                iEdit.classList.add('bi-pencil-square');

                aEdit.href = "/equipe/edit/" + element.id;
                aEdit.appendChild(iEdit);

                let aDelete = document.createElement('a');
                let iDelete = document.createElement('i');
                iDelete.classList.add('bi');
                iDelete.classList.add('bi-trash');

                aDelete.addEventListener('click', (e) => {
                    //send popup
                    e.preventDefault();
                    let m = prompt("Voulez-vous vraiment supprimer cette équipe ? (oui/non)");
                    if (m === "oui") {
                        window.location.href = "/equipe/delete/" + element.id;
                    }
                });
                aDelete.appendChild(iDelete);
                let section = document.createElement('section');
                section.classList.add('buttonSection');

                section.appendChild(aEdit);
                section.appendChild(aDelete);
                infoSection.appendChild(section);
            }

            teamSection.appendChild(infoSection)
            teamSection.classList.add("teamArticle")

            sectionallTeam.appendChild(teamSection);
        })
        let load = document.getElementById("loader");
        load.remove();
    })
}

getAllTeam();

function isCripted(urlPhoto) {
    if (urlPhoto.length === 36) {
        return true;
    }
    return false;
}