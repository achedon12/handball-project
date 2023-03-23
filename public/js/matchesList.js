let categoriesSelect = document.getElementById('category');
let gymnaseSelect = document.getElementById('gymnase');
let domicileSelect = document.getElementById('domicile');
let matchContent = document.querySelector('.content');
// let dateSelect = document.getElementById('date');
//
// dateSelect.addEventListener('change', select => {
//     console.log("date changed");
// });

let selects = [
    categoriesSelect,
    gymnaseSelect,
    domicileSelect,
    // dateSelect
];


function displayMatchtes() {
    let caterogyValue = getSelectValue('category');
    let gymnaseValue = getSelectValue('gymnase');
    let divLoader = document.createElement('div');
    divLoader.className = "loader"
    let domicileValue = domicileSelect.checked;
    domicileValue = domicileValue ? 1 : 0;

    fetch('/api/allMatches?equipe_locale=' + caterogyValue + '&gymnase=' + gymnaseValue + '&domicile_exterieur=' + domicileValue+"&date=all")
        .then(response => response.json())
        .then(data => {
            console.log(data);
            for (let match in data) {
                match = data[match];
                let a = document.createElement('section');
                a.className = 'list-group-item list-group-item-action';
                let h3 = document.createElement('h3');
                h3.className = 'list-group-item-heading';
                let date = new Date(match.dateHeure);
                h3.innerHTML = match.equipeLocale + ' contre ' + match.equipeAdverse;
                let divInfo = document.createElement('section');
                let dateText = document.createElement('p');
                let lieuText = document.createElement('p');
                let heureText = document.createElement('p');

                dateText.innerHTML = new Date(match.dateHeure).toLocaleDateString();
                lieuText.innerHTML = match.gymnase;
                heureText.innerHTML = date.toLocaleTimeString();

                divInfo.className = 'list-group-item-text';
                divInfo.appendChild(dateText);
                divInfo.appendChild(lieuText);
                divInfo.appendChild(heureText);


                let role = document.getElementById("role").textContent;
                if (role.trim() === 'ROLE_ADMIN') {
                    let aEdit = document.createElement('a');
                    let iEdit = document.createElement('i');
                    iEdit.classList.add('bi');
                    iEdit.classList.add('bi-pencil-square');

                    aEdit.href = "/match/edit/" + match.id;
                    aEdit.appendChild(iEdit);

                    let aDelete = document.createElement('a');
                    let iDelete = document.createElement('i');
                    iDelete.classList.add('bi');
                    iDelete.classList.add('bi-trash');

                    aDelete.addEventListener('click', (e) => {
                        e.preventDefault();
                        let m = prompt("Voulez-vous vraiment supprimer ce match ? (oui/non)");
                        if (m === "oui") {
                            window.location.href = "/match/delete/" + match.id;
                        }
                    });
                    aDelete.appendChild(iDelete);
                    let section = document.createElement('section');
                    section.className = 'icons';
                    section.appendChild(aEdit);
                    section.appendChild(aDelete);
                    divInfo.appendChild(section);
                }
                a.appendChild(h3);
                a.appendChild(divInfo);
                matchContent.appendChild(a);
            }
            let load = document.getElementById("loader");
            load.remove();
        })
        .catch(error => console.error(error)
        )

}

fetch('/api/allCategories')
    .then(response => response.json())
    .then(data => {
        data.forEach(category => {
            let option = document.createElement('option');
            option.value = category.equipe_locale;
            option.text = category.equipe_locale;
            categoriesSelect.appendChild(option);
        });
    })
    .catch(error => console.error(error)
    );

fetch('/api/allGymnases')
    .then(response => response.json())
    .then(data => {
        data.forEach(gymnase => {
            let option = document.createElement('option');
            option.value = gymnase.gymnase;
            option.text = gymnase.gymnase;
            gymnaseSelect.appendChild(option);
        });
    })
    .catch(error => console.error(error)
    );

function getSelectValue(selectId) {
    let selectElmt = document.getElementById(selectId);
    return selectElmt.options[selectElmt.selectedIndex].value;
}

selects.forEach(select => {
    select.addEventListener('change', select => {
        matchContent.innerHTML = '';
        displayMatchtes();
    });
});
displayMatchtes();