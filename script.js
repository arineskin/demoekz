const images = ['images/1.jpg', 'images/2.jpg', 'images/3.jpg', 'images/4.jpg'];
let current = 0;
const img = document.getElementById('slider-img');

if (img) {
    setInterval(function() {
        current = (current + 1) % images.length;
        img.src = images[current];
    }, 3000);
}