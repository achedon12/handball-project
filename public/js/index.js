let imgCount = 1;
let images = [];

fetch("/api/allTeam")
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        data.forEach(element => {
            images.push(element.urlPhoto);
        });
    })
    .catch((error) => {
        console.log(error);
    });

let img = document.querySelector(".img");

setInterval(() => {
    imgCount++;
    if (imgCount - 1 >= images.length) {
        imgCount = 1;
    }
    let src = "/images/" + images[imgCount - 1];
    if (isCripted(images[imgCount - 1])) {
        src = "/uploads/images/" +images[imgCount - 1];
    }
    img.src = src;
    img.alt = images[imgCount - 1];
}, 10000);


let newElement = document.querySelectorAll(".news-element");
newElement.forEach((element) => {
    element.addEventListener("mouseout", () => {
        element.classList.remove("hover");
        newElement.forEach((element2) => {
            if (element !== element2) {
                element2.classList.remove("notHover");
            }
        });
    });

    element.addEventListener("mouseover", () => {
        element.classList.add("hover");
        newElement.forEach((element2) => {
            if (element !== element2) {
                element2.classList.add("notHover");
            }
        });
    });
});

function setPosts() {
    removePosts();
    for (let i = 0; i < posts.length; i++) {
        let a = document.createElement('a');
        a.classList.add('news-element');
        a.id = posts[i].id;
        a.href = '/post/' + posts[i].id;
        let h3 = document.createElement('h3');
        h3.classList.add('name');
        h3.innerHTML = posts[i].author;
        let p = document.createElement('p');
        p.classList.add('content');
        p.innerHTML = posts[i].title;
        let img = document.createElement('img');
        img.classList.add('news-element-img');
        img.src = '/posts/images/' + posts[i].url_photo;
        a.appendChild(h3);
        a.appendChild(p);
        a.appendChild(img);
        document.querySelector('.news-content').appendChild(a);
    }
}

function removePosts() {
    let elements = document.querySelectorAll('.news-element');
    elements.forEach(element => {
        element.remove();
    });
}

function isCripted(urlPhoto) {
    if (urlPhoto.length === 36) {
        return true;
    }
    return false;
}