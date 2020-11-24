// coords
var coordX = document.querySelector('#x');
var coordY = document.querySelector('#y');
var coordZ = document.querySelector('#z');

// result coords
var resX = document.querySelector('#resX');
var resY = document.querySelector('#resY');
var resZ = document.querySelector('#resZ');

var resultContainer = document.querySelector('#result-container');

var option = document.querySelector('#option');

var calculateForm = document.querySelector('#calculateForm');

calculateForm.addEventListener('submit', (e) => {
    e.preventDefault();
    calculate()
})

resultContainer.style.display = 'none';

function calculate() {
    if (!Number.isNaN(coordX.value) && !Number.isNaN(coordY.value) && !Number.isNaN(coordZ.value)) {
        let x = parseInt(coordX.value);
        let y = parseInt(coordY.value);
        let z = parseInt(coordZ.value);
        resultContainer.style.display = 'block';
        if (option.value == "otn") {
            resX.innerText = x / 8;
            resY.innerText = y / 8;
            resZ.innerText = z / 8;
        } else {
            resX.innerText = x * 8;
            resY.innerText = y * 8;
            resZ.innerText = z * 8;

        }
    } else {
        alert("You need to write a Number, not TEXT");
    }
}