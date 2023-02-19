let categoriesSelect = document.getElementById('category');
let gymnaseSelect = document.getElementById('gymnase');
let domicileSelect = document.getElementById('domicile');
let matchContent = document.querySelector('.content');

let selects = [
    categoriesSelect,
    gymnaseSelect,
    domicileSelect
];

displayMatchtes();

function displayMatchtes(){
    let caterogyValue = getSelectValue('category');
    let gymnaseValue = getSelectValue('gymnase');

    fetch('/api/allMatches?equipe_locale=' + caterogyValue + '&gymnase=' + gymnaseValue +  '&domicile_exterieur=' + domicileSelect.value)
        .then(response => response.json())
        .then(data => {
            data.forEach(match => {
                let a = document.createElement('a');
                a.href = '/match/show/' + match.id;
                a.className = 'list-group-item list-group-item-action';
                let h1 = document.createElement('h1');
                h1.className = 'list-group-item-heading';
                let date = new Date(match.dateHeure);
                h1.innerHTML = match.equipeLocale + ' - ' + match.equipeAdverse;
                let p = document.createElement('p');
                p.className = 'list-group-item-text';
                p.innerHTML = new Date(match.dateHeure).toLocaleDateString() + ' - ' + match.gymnase + ' - ' + date.toLocaleTimeString();
                a.appendChild(h1);
                a.appendChild(p);
                matchContent.appendChild(a);
            });
        })
        .catch(error => console.error(error)
        );

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
   select.addEventListener('change', () => {
         matchContent.innerHTML = '';
       displayMatchtes();
   });
});