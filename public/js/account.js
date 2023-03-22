let colors = [
    '#7F0000',
    '#B25600',
    '#007F00',
    '#1F1F7F',
    '#43007F',
    '#7F007D',
    '#00597F',
    '#007F4E',
];

document.querySelectorAll('.element i').forEach(function (element) {
    element.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
});
