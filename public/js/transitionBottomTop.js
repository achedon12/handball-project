/**
 *
 * transition de droite a gauche de l'apparition des élément
 *
 */

const ratio = 0.3;

const options = {
    root: null,
    rootMargin: '0px',
    threshold: ratio
}

const handleIntersect = function (entries, observer) {
    entries.forEach(function (entry) {
        if(entry.intersectionRatio>ratio){
            entry.target.classList.add('reveal_bottom_visible');
            observer.unobserve(entry.target);
        }
    });
}


const observer = new IntersectionObserver(handleIntersect, options)
document.querySelectorAll('.reveal_bottom').forEach(function (r){
    observer.observe(r)
} )