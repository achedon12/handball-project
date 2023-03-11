function displayUsers() {
    fetch('/api/allUsers')
        .then(response => response.json())
        .then(users => {
            users.forEach(user => {
                let card = document.createElement('div');
                card.classList.add('card');
                let cardBody = document.createElement('div');
                cardBody.classList.add('card-body');

                let details = document.createElement('details');

                let summary = document.createElement('summary');
                summary.textContent = user.pseudo;

                let pMail = document.createElement('p');
                pMail.textContent = user.email;

                let pRole = document.createElement('p');
                pRole.textContent = user.role;

                let aEdit = document.createElement('a');
                aEdit.href = "/account/manage/edit/" + user.id;
                let iEdit = document.createElement('i');
                iEdit.classList.add('bi');
                iEdit.classList.add('bi-pencil-square');
                aEdit.appendChild(iEdit);

                let aDelete = document.createElement('a');
                let iDelete = document.createElement('i');
                iDelete.classList.add('bi');
                iDelete.classList.add('bi-trash');
                aDelete.appendChild(iDelete);
                aDelete.addEventListener('click', (e) => {
                    e.preventDefault();
                    let m = prompt("Voulez-vous vraiment supprimer cet utilisateur ? (oui/non)");
                    if (m === "oui") {
                        window.location.href = "/account/manage/delete/" + user.id;
                    }
                });

                details.appendChild(summary);
                details.appendChild(pMail);
                details.appendChild(pRole);
                details.appendChild(aEdit);
                details.appendChild(aDelete);

                cardBody.appendChild(details);
                card.appendChild(cardBody);
                document.getElementById("allUsers").appendChild(card);
            });
        });
}

displayUsers();