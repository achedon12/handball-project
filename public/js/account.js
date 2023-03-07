let colors = [
    '#FF0000',
    '#FF7F00',
    '#00FF00',
    '#0000FF',
    '#8B00FF',
];

document.querySelectorAll('.element i').forEach(function (element) {
    element.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
});
