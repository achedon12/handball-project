let categoriesSelect = document.getElementById('category');
let gymnaseSelect = document.getElementById('gymnase');
fetch('/api/allMatches')
    .then(response => response.json())
    .then(data => {
        data.forEach(match => {
        });
    })
    .catch(error => console.error(error)
);

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


