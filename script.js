const images = ['images/1.jpg', 'images/2.jpg', 'images/3.jpg', 'images/4.jpg'];
let current = 0;
const img = document.getElementById('slide');

function next() {
    current = current + 1;
    if (current >= images.length) current = 0;
    img.src = images[current];
}

function prev() {
    current = current - 1;
    if (current < 0) current = images.length - 1;
    img.src = images[current];
}

document.getElementById('next').onclick = next;
document.getElementById('prev').onclick = prev;
setInterval(next, 2000);
