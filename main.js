var body = document.querySelector('body');


function randomBackground() {

    body.style.backgroundImage = 'url(images/backgrounds/' + (Math.floor(Math.random() * 53) + 1) + '.png';
}

randomBackground();